/* eslint-disable no-undef */

jQuery(document).ready(function ($) {

    $(document).ready(function() {
        $('button.filter_tag').click(function() {
            // Remove active class from all buttons
            $(this).toggleClass('active');
        
            // Remove active class from other buttons
            $('button.filter_tag').not(this).removeClass('active');
            
            // Get the data-value attribute of the clicked button
            var dataValue = $(this).data('value').toLowerCase();
            if($(this).hasClass('active')){
              filterTable(dataValue)
            }else{
              $("ul.filter_store_ul_data li").show();
            }
            

        });
        $('button.filter_button').click(function() {
            // Remove active class from all buttons
            $('button.filter_tag').not(this).removeClass('active');
            // Add active class to the clicked button
            $(this).toggleClass('active');
            
            // Get the data-value attribute of the clicked button
            var dataValue = $(this).data('value');
            if($(this).hasClass('active')){
                  if (dataValue === "new") {
                    $("ul.filter_store_ul_data li").each(function() {
                        var $hiddenInput = $(this).find('input[type="hidden"]');
                        var isInputValueNew = $hiddenInput.val() === "new";
                        var text = $(this).text().toLowerCase();
                        var match = text.indexOf(dataValue) > -1;
                        if (match || isInputValueNew) {
                            $(this).show(); // Show the element if it matches the criteria
                        } else {
                            $(this).hide(); // Hide the element if it doesn't match the criteria
                        }
                    });
                } else if(dataValue ==="popular"){

                  $("ul.filter_store_ul_data li").each(function() {
                    var $searchTextInput = $(this).find('input[type="hidden"][name="popular"]');
                    var searchTextVal = $searchTextInput.val(); 
                    var listItemText = $(this).text().toLowerCase();
                    var dataValue = "popular"; 
                    var match = listItemText.indexOf(dataValue) > -1 || searchTextVal === "popular"; 
                    if (match) {
                        $(this).show(); 
                    } else {
                        $(this).hide(); 
                    }
                });                
                
                }else {
                    $("ul.filter_store_ul_data li").show();
                }
            }else {
                $("ul.filter_store_ul_data li").show();
            }
         
          
        });

        $("button.feedback_btn").on('click', function() {
            $("div.popup_for_add_data").addClass('model-open');
          }); 
          $("div.close-btn.add_data, div.bg-overlay.add_data").click(function(){
            $("div.popup_for_add_data").removeClass('model-open');
            window.location.reload();
          });

  
          

          function validateEmail(email) {
              // Regular expression pattern for email validation
              var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
              return pattern.test(email);
          }
          function filterTable(value) {
            $("ul.filter_store_ul_data li").each(function() {
                var text = $(this).text().toLowerCase(); 
                var match = text.indexOf(value) > -1; 
                $(this).toggle(match); 
            });
          }

        $("li.show_content_popup_btn").on('click', function() {
          var dataId = $(this).attr('data-id');
          var tabType = $(this).attr('data-tabType');
          $("#push_exploring_popup_data").html("");
          $("#push_inprogress_popup_data").html("");
          $("#push_done_popup_data").html("");
          $("div.show_data_into_popup").addClass('model-open');
          $("div.loading_for_show_popup_data").fadeIn("slow");
          $("div.modal-container").css({
            "height": "700px "
          })

              $.ajax({
                // eslint-disable-next-line no-undef
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'popup_content_showing_after_click_action', // Ajax action name
                    nonce: ajax_data.nonce6 ,
                    dataId,
                    tabType,
                },
                success(response) {
                    // Handle Ajax response
                    $("div.modal-container").css({
                      "height": "auto ",
                      "max-height": "700px",
                    })
                    if(response.data.tabType ==="exploring"){
                      $("#push_exploring_popup_data").html(response.data.html);
                      $("div.modal-container").css({
                        "height": "auto ",
                        "max-height": "700px",
                      })
                      $("div.loading_for_show_popup_data").fadeOut("slow");
                    }else if(response.data.tabType === "inprogress"){
                      $("#push_inprogress_popup_data").html(response.data.html);
                      $("div.loading_for_show_popup_data").fadeOut("slow");
                      $("div.modal-container").css({
                        "height": "auto ",
                        "max-height": "700px",
                      })
                    }else if(response.data.tabType === "done"){
                      $("#push_done_popup_data").html(response.data.html);
                      $("div.loading_for_show_popup_data").fadeOut("slow");
                      $("div.modal-container").css({
                        "height": "auto ",
                        "max-height": "700px",
                      })
                    }
              

                    $("span.upvote_icon").on("click", function(){
                                  
                      $(this).toggleClass("active");
                      $("span.downvote_icon").removeClass("active"); 
                      if($(this).hasClass("active")){
                        $("div.agree_disagree_hidden_div").fadeIn(100);
                      }else{
                        $("div.agree_disagree_hidden_div").fadeOut(100);
                      }


                    });
                    $("span.downvote_icon").on("click", function(){                                 
                      $(this).toggleClass("active");
                      $("span.upvote_icon").removeClass("active");  
                      if($(this).hasClass("active")){
                        $("div.agree_disagree_hidden_div").fadeIn(100);
                      }else{
                        $("div.agree_disagree_hidden_div").fadeOut(100);
                      }
                      


                    });


                    $('span.voting_span.active, span.after_voting_done_msg').mouseenter(function() {
                      // Add the 'hovered' class to both elements
                    
                      $('span.after_voting_done_msg').addClass('hovered');
                  });
                  
                  // Add event handler for mouse leave on voting span and after_voting_done_msg
                  $('span.voting_span.active, span.after_voting_done_msg').mouseleave(function() {
                      // Remove the 'hovered' class from both elements
                    
                      $('span.after_voting_done_msg').removeClass('hovered');
                  });

                   
                    comment_reply_attachment_event();
                    comment_edit_attachment_event(dataId);
                    comment_trash_attachment_event(dataId);
                    remove_vote_btn_event();
                

                    //  voting process 
                    $("button.vote_btn").on("click", function(){
                      var email_value = $("#voting_email_field").val();
                      var textArea = $("#hidden_div_content").val();
                      var select = $("span.voting_span.active").attr("data-name");
                      var report_table_id_val = $("#report_table_id_val").val();
                      var keep_me_posted = $("#keep_me_posted").val();
                      
                      

                      if(!validateEmail(email_value)){
                              $(".submittes_result_massage").text("Email are required");
                      }else{
                        $(".submittes_result_massage").text("");
                        
                      }
 
                      if(validateEmail(email_value)){
                        $("div.loading_for_show_popup_data").fadeIn("slow");
                        $.ajax({
                          // eslint-disable-next-line no-undef
                          url: ajax_data.ajax_url,
                          type: 'POST',
                          data: {
                              action: 'voting_store_database_action', // Ajax action name
                              nonce: ajax_data.nonce7 ,
                              email_value,
                              textArea,
                              select,
                              report_table_id_val,
                              keep_me_posted
                          },
                          success(response) {
                            if(response.data.status){
                              $("div.agree_disagree_hidden_div").fadeOut(100);
                              $("select#agree_disagree_select").fadeOut(100);
                              $(".voted_done_and_counting_box").append(response.data.voting_done_msg_html);
                              $("span.after_voting_done_msg").addClass("hovered");    
                              $("span.total_agree_vote_count_"+ dataId).text(response.data.total_agree_voting );
                              $("span.total_disagree_vote_count_"+ dataId).text(response.data.total_disagree_voting );
                              $("span.voting_span").addClass("disabled");
                              
                              Swal.fire("You Have Voted!", "", "success");
                              $("div.loading_for_show_popup_data").fadeOut("slow");


                              setTimeout(()=>{
                                remove_vote_btn_event();
                              } , 200);


                           
                            }

                          },
                          error(xhr, status, error) {
      
                            console.log(error);
                        }
                        });
                      }
                    });
                    // voting process end 

                    // comment process 
                    $("button.comment_btn").on("click", function(e) {
                      
                      var comment_type = $(this).attr("data-comment-type");
                      var cTextarea = $("#comment_textarea").val();
                      var comment_email_field = $("#comment_email_field").val();
                      var commentator_name = $("#comment_name_field").val();
                      var report_table_id_val = $("#report_table_id_val").val();
                       var commentReplyMail = $(this).attr("data-replymail");
                       var commentId = $(this).attr("data-commentid");
                      var requestFrom ="publicUser";
                      if(!validateEmail(comment_email_field)){
                        $("p.comment_result_massage").text("Email are required");
                      }else if(cTextarea == "" || commentator_name == ""){
                        $("p.comment_result_massage").text("Fields are required");
                      }else{
                        $("p.comment_result_massage").text("");
                        $(this).text("Wait....");
                      }


                      if(validateEmail(comment_email_field) && cTextarea != "" && commentator_name != ""){
                        $.ajax({
                          // eslint-disable-next-line no-undef
                          url: ajax_data.ajax_url,
                          type: 'POST',
                          data: {
                              action: 'comment_store_database_action', // Ajax action name
                              nonce: ajax_data.nonce8 ,
                              comment_type ,
                              commentator_name,
                              comment_email_field,
                              cTextarea,
                              report_table_id_val,
                              requestFrom,
                              commentReplyMail,
                              commentId
                          },
                          success(response) {
                            if(response.data.status){
                              $("p.comment_result_massage").addClass("success");
                              $("button.comment_btn").text("Comment");
                              $("b.comment_updated_status_" + dataId).text(response.data.commenting_details);
                              $("p.comment_result_massage").text("Comment added successfully");
                              $("button.comment_btn").attr("data-comment-type" , "comment");
                              $(".leave_comment_title").text("Leave a Comment");
                              $("ul.push_comment_into_ul").html(response.data.comment_html);
                              $("#comment_textarea").val("");
                              $("#comment_email_field").val("");
                              $("#comment_name_field").val("");


                                          
                              comment_reply_attachment_event();
                              comment_edit_attachment_event(dataId);
                              comment_trash_attachment_event(dataId);
                  
                            }
                          

                          },
                          error(xhr, status, error) {
      
                            console.log(error);
                        }
                        });
                      }


                    })

                    // comment process end 
                },
                error(xhr, status, error) {
      
                    console.log(error);
                }
            });
         
            
          }); 

          $("div.close-btn.show_data, div.bg-overlay.show_data").click(function(){
            $("div.show_data_into_popup").removeClass('model-open');
            window.location.reload();
          });

          


          $('#material-tabs').each(function() {

                  var $active, $content, $links = $(this).find('a');

                  $active = $($links[0]);
                  $active.addClass('active');

                  $content = $($active[0].hash);

                  $links.not($active).each(function() {
                          $(this.hash).hide();
                  });

                  $(this).on('click', 'a', function(e) {

                          $active.removeClass('active');
                          $content.hide();

                          $active = $(this);
                          $content = $(this.hash);

                          $active.addClass('active');
                          $content.show();

                          e.preventDefault();
                  });
          });


         

    
    $("form#issues_form").on("submit", function(e){
      e.preventDefault();

      var formData = $(this).serialize();
      $("div#loading_overlay").fadeIn(100);
      $("p.submisson_msg").text("");

        $.ajax({
          // eslint-disable-next-line no-undef
          url: ajax_data.ajax_url,
          type: 'POST',
          data: {
              action: 'issues_submitted_form_action', // Ajax action name
              nonce: ajax_data.nonce2 ,
              formData,
          },
          success(response) {
              // Handle Ajax response
              if(response.data.status === true){
                
                $("#loading_overlay").fadeOut(100);
                $("p.submisson_msg").text("Issues submitted successfully").addClass("success").delay(2000).fadeOut(100);
                setTimeout(function() {
                  $("div.popup_for_add_data").removeClass('model-open');
                  get_store_explore_data_from_database();
                  get_store_inprogress_data_from_database();
                  get_store_done_data_from_database();
                  window.location.reload();
              }, 2000);
              
                $('form#issues_form')[0].reset();
                get_store_explore_data_from_database();
                get_store_inprogress_data_from_database();
                get_store_done_data_from_database();
              }else{
                $("p.submisson_msg").text("There was an error").addClass("error").delay(2000).fadeOut(100);
              }
          },
          error(xhr, status, error) {

              $("p.submisson_msg").text(error);
          }
      });

    });
    $("form#suggestion_form").on("submit", function(e){
      e.preventDefault();

      var formData = $(this).serialize();
      $("div#loading_overlay").fadeIn(100);
      $("p.for_suggestion").text("");

        $.ajax({
          // eslint-disable-next-line no-undef
          url: ajax_data.ajax_url,
          type: 'POST',
          data: {
              action: 'suggestion_submitted_form_action', // Ajax action name
              nonce: ajax_data.nonce1 ,
              formData,
          },
          success(response) {
              // Handle Ajax response
              if(response.data.status === true){
               
                $("#loading_overlay").fadeOut(100);
                $("p.for_suggestion").text("Suggestion submitted successfully").addClass("success").delay(2000).fadeOut(100);
                setTimeout(function() {
                  $("div.popup_for_add_data").removeClass('model-open');
                  get_store_explore_data_from_database();
                  get_store_inprogress_data_from_database();
                  get_store_done_data_from_database();
                  window.location.reload();
                  
              }, 2000);
                $('form#suggestion_form')[0].reset();
                get_store_explore_data_from_database();
                get_store_inprogress_data_from_database();
                get_store_done_data_from_database();
              }else{
                $("p.submisson_msg").text("There was an error").addClass("error").delay(2000).fadeOut(100);
              }
          },
          error(xhr, status, error) {

              $("p.for_suggestion").text(error);
          }
      });

    });


 

    function get_store_explore_data_from_database(){
        $.ajax({
          // eslint-disable-next-line no-undef
          url: ajax_data.ajax_url,
          type: 'POST',
          data: {
              action: 'get_store_explore_data_from_database_action', // Ajax action name
              nonce: ajax_data.nonce3 ,
          },
          success(response) {
            $("ul.show_store_exploring_database_data").html(response.data.html);
          },
          error(xhr, status, error) {

            console.log(error);
          }
      });
    }


    function get_store_inprogress_data_from_database(){
        $.ajax({
          // eslint-disable-next-line no-undef
          url: ajax_data.ajax_url,
          type: 'POST',
          data: {
              action: 'get_store_inprogress_data_from_database_action', // Ajax action name
              nonce: ajax_data.nonce4 ,
          },
          success(response) {
            $("ul.show_store_inprogress_database_data").html(response.data.html);
          },
          error(xhr, status, error) {

            console.log(error);
          }
      });
    }

    function get_store_done_data_from_database(){
        $.ajax({
          // eslint-disable-next-line no-undef
          url: ajax_data.ajax_url,
          type: 'POST',
          data: {
              action: 'get_store_done_data_from_database_action', // Ajax action name
              nonce: ajax_data.nonce5 ,
          },
          success(response) {
            $("ul.show_store_done_database_data").html(response.data.html);
          },
          error(xhr, status, error) {

            console.log(error);
          }
      });
    }

    

  
    function comment_edit_attachment_event(dataId){
      $("span.comment_edit").on("click", function(){
        var commentId = $(this).attr("data-commentId");
        var reportId = $(this).attr("data-reportId");
        var  commenttype = $(this).attr("data-commenttype");
        Swal.fire({
          title: "Enter Your Email Address",
          input: "text",
          inputAttributes: {
              autocapitalize: "off"
          },
          showCancelButton: true,
          confirmButtonText: "Edit Comment",
          showLoaderOnConfirm: true,
          inputValidator: (value) => !value && 'You need to write something!',
          preConfirm: (value) => {
            return new Promise((resolve) => {
                Swal.showLoading(); // Show loading effect
                $.ajax({
                    url: ajax_data.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'edit_comment_data_action', // Ajax action name
                        nonce: ajax_data.edit_comment,
                        comment_email: value,
                        commentId,
                        reportId,
                        commenttype
                    },
                    success(response) {
                        resolve(response); // Resolve the promise with the AJAX response
                    },
                    error(xhr, status, error) {
                        console.log(error);
                        Swal.hideLoading(); // Hide loading effect in case of error
                        resolve(error); // Resolve the promise with false to close the dialog
                    }
                });
            });
        },
          allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        
          if (result && result !== false) {
            if(result.value.data.status){
              const responseData = result.value.data.data_all_data;
            
              const comment_email = responseData[0].comment_email;
              const comment_text = responseData[0].comment_text;
              const commentator_name = responseData[0].commentator_name;
                Swal.fire({
                  title: "Edit Your Comment",
                  html: `<div><textarea class="comment_update_textarea" placeholder="Enter Comment Text" >${comment_text}</textarea> <input class="comment_update_name" type="text" value="${commentator_name}" placeholder="Enter Name" /> </div>`,
                  showCancelButton: true,
                  confirmButtonText: "Saved",
                  showLoaderOnConfirm: true,
                  
                  preConfirm: () => {
                    const textareaValue = $('.comment_update_textarea').val();
                    const nameValue = $('.comment_update_name').val();
            
                    if (!textareaValue  || !nameValue) {
                        Swal.showValidationMessage('All fields are required');
                        return false; // Prevent the popup from closing
                    }

                    return new Promise((resolve) => {
                      Swal.showLoading(); // Show loading effect
                      $.ajax({
                          url: ajax_data.ajax_url,
                          type: 'POST',
                          data: {
                              action: 'update_comment_data_action', // Ajax action name
                              nonce: ajax_data.update_comment,
                              comment_email,
                              textareaValue,
                              nameValue,
                              commentId,
                              reportId,
                              commenttype
                          },
                          success(response) {
                              resolve(response); // Resolve the promise with the AJAX response
                          },
                          error(xhr, status, error) {
                              console.log(error);
                              Swal.hideLoading(); // Hide loading effect in case of error
                              resolve(error); // Resolve the promise with false to close the dialog
                          }
                      });
                  });
                    
                },
                allowOutsideClick: () => !Swal.isLoading()
                  
              }).then((result) => {
                if (result.isConfirmed) {
                  if(result.value.data.status){
                    Swal.fire("Comment Updated Successfull!");
                    $("ul.push_comment_into_ul").html(result.value.data.comment_html);
                    $("b.comment_updated_status_" + dataId).text(result.value.data.total_count_comment);
                    setTimeout(() => {
                              comment_reply_attachment_event();
                              comment_edit_attachment_event(dataId);
                              comment_trash_attachment_event(dataId);
                  }, 500);
                    
                  }
                }
               

                
              });

            }else{
              Swal.fire("No Comment found!");
            }
          
        }
      
      });
      

      })
    }



    function comment_reply_attachment_event(){
      var prevCommentId = null;
      var currentCommentId = null;
      var currentCommentator = null;
      var replymail = null;
          $(".comment_reply_icon").on("click", function(){
            // Get the current commentId
            currentCommentId = $(this).attr("data-commentId");
            currentCommentator = $(this).attr("data-commentator");
            replymail = $(this).attr("data-replymail");
        
            // Toggle the HTML content for the clicked icon
            var curentHtml = $(this).html();
            if (curentHtml.includes("fa-reply")) {
                $(this).html('<i class="fa-solid fa-ban"></i>');
                $(".leave_comment_title").text("Reply to @" + currentCommentator);
                $(".comment_btn").text("Reply");
                $(".comment_btn").attr("data-comment-type", "reply");
                $(".comment_btn").attr("data-replymail", replymail);
                $(".comment_btn").attr("data-commentid", currentCommentId);
            } else {
                $(this).html('<i class="fa-solid fa-reply"></i>');
                $(".leave_comment_title").text("Leave a Comment");
                $(".comment_btn").text("Comment");
                $(".comment_btn").attr("data-comment-type", "comment");
                $(".comment_btn").attr("data-replymail", "");
                $(".comment_btn").attr("data-commentid", "");
            }
        
            // Toggle the HTML content for the previously clicked icon (if any)
            if (prevCommentId && prevCommentId !== currentCommentId) {
                $(".comment_reply_icon[data-commentId='" + prevCommentId + "']").html('<i class="fa-solid fa-reply"></i>'); 
                $(".leave_comment_title").text("Reply to @"+ currentCommentator);
                $(".comment_btn").text("Reply");
                $(".comment_btn").attr("data-comment-type", "reply");
                $(".comment_btn").attr("data-replymail", replymail);
                $(".comment_btn").attr("data-commentid", currentCommentId);
            }
        
            // Update the previous commentId
            prevCommentId = currentCommentId;
        });
    }


    function comment_trash_attachment_event(dataId){
      $("span.comment_trash").on("click", function(){
        var commentId = $(this).attr("data-commentId");
        var reportId = $(this).attr("data-reportId");
        var  commenttype = $(this).attr("data-commenttype");
        Swal.fire({
          title: "Enter Your Email Address",
          input: "text",
          inputAttributes: {
              autocapitalize: "off"
          },
          showCancelButton: true,
          confirmButtonText: "Enter",
          showLoaderOnConfirm: true,
          inputValidator: (value) => !value && 'You need to write something!',
          preConfirm: (value) => {
            return new Promise((resolve) => {
                Swal.showLoading(); // Show loading effect
                $.ajax({
                    url: ajax_data.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'edit_comment_data_action', // Ajax action name
                        nonce: ajax_data.edit_comment,
                        comment_email: value,
                        commentId,
                        reportId,
                        commenttype
                    },
                    success(response) {
                        resolve(response); // Resolve the promise with the AJAX response
                    },
                    error(xhr, status, error) {
                        console.log(error);
                        Swal.hideLoading(); // Hide loading effect in case of error
                        resolve(error); // Resolve the promise with false to close the dialog
                    }
                });
            });
        },
          allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        
        var comment_email = result.value.data.data_all_data[0].comment_email;
          if (result && result !== false) {
            if(result.value.data.status){
               Swal.fire({
                  title: "Are you Sure ?",
                  text: "Want to delete this comment",
                  showCancelButton: true,
                  confirmButtonText: "Delete",
                  showLoaderOnConfirm: true,
                  
                  preConfirm: () => {
                    

                    return new Promise((resolve) => {
                      Swal.showLoading(); // Show loading effect
                      $.ajax({
                          url: ajax_data.ajax_url,
                          type: 'POST',
                          data: {
                              action: 'delete_comment_data_action', // Ajax action name
                              nonce: ajax_data.delete_comment,
                              comment_email,
                              commentId,
                              reportId,
                              commenttype
                          },
                          success(response) {
                              resolve(response); // Resolve the promise with the AJAX response
                          },
                          error(xhr, status, error) {
                              console.log(error);
                              Swal.hideLoading(); // Hide loading effect in case of error
                              resolve(error); // Resolve the promise with false to close the dialog
                          }
                      });
                  });
                    
                },
                allowOutsideClick: () => !Swal.isLoading()
                  
              }).then((result) => {
                
                if (result.isConfirmed) {
                  if(result.value.data.status){
                    $("ul.push_comment_into_ul").html(result.value.data.comment_html);
                    $("b.comment_updated_status_" + dataId).text(result.value.data.total_count_comment);
                    Swal.fire("Comment Deleted Successfull!");
                    setTimeout(() => {
                              comment_reply_attachment_event();
                              comment_edit_attachment_event(dataId);
                              comment_trash_attachment_event(dataId);
                  }, 500);
                    
                  }
                }
                

                
              });

            }else{
              Swal.fire("No Comment found!");
            }
           
        }
        
      });
      

      })
    }


    function remove_vote_btn_event(){
      var report_table_id_val = $("#report_table_id_val").val();
      $(".remove_vote_btn").on("click", function(){
        
        Swal.fire({
          title: "Enter Your Email Address",
          input: "text",
          inputAttributes: {
              autocapitalize: "off"
          },
          showCancelButton: true,
          confirmButtonText: "Enter",
          showLoaderOnConfirm: true,
          inputValidator: (value) => !value && 'You need to write something!',
          preConfirm: (value) => {
            return new Promise((resolve) => {
                Swal.showLoading(); // Show loading effect
                $.ajax({
                    url: ajax_data.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'voting_email_checking_action', // Ajax action name
                        nonce: ajax_data.vote_email_check,
                        voting_email: value,           
                        reportId:report_table_id_val ,
                    },
                    success(response) {
                        resolve(response); // Resolve the promise with the AJAX response
                    },
                    error(xhr, status, error) {
                        console.log(error);
                        Swal.hideLoading(); // Hide loading effect in case of error
                        resolve(error); // Resolve the promise with false to close the dialog
                    }
                });
            });
        },
          allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
      
        if ( result.value.data.status !== false ) {
            if(result.value.data.status){
              Swal.fire({
                  title: "Are you Sure ?",
                  text: "Want to remove your vote",
                  showCancelButton: true,
                  confirmButtonText: "Remove",
                  showLoaderOnConfirm: true,
                  
                  preConfirm: () => {
                    

                    return new Promise((resolve) => {
                      Swal.showLoading(); // Show loading effect
                      $.ajax({
                          url: ajax_data.ajax_url,
                          type: 'POST',
                          data: {
                              action: 'remove_vote_from_database_action', // Ajax action name
                              nonce: ajax_data.nonce9,
                              report_table_id_val,
                              voter_email : result.value.data.data_all_data[0].vote_email
                              
                          },
                          success(response) {
                              resolve(response); // Resolve the promise with the AJAX response
                          },
                          error(xhr, status, error) {
                              console.log(error);
                              Swal.hideLoading(); // Hide loading effect in case of error
                              resolve(error); // Resolve the promise with false to close the dialog
                          }
                      });
                  });
                    
                },
                allowOutsideClick: () => !Swal.isLoading()
                  
              }).then((result) => {
                console.log(result);
                var dataId = result.value.data.report_table_id_val;
                if (result.isConfirmed) {
                  if(result.value.data.status){
                    $("span.total_agree_vote_count_"+ dataId).text(result.value.data.total_agree_voting );
                    $("span.total_disagree_vote_count_"+ dataId).text(result.value.data.total_disagree_voting );
                    $(".after_voting_done_msg").fadeOut(100);                                  
                    
                      $("span.voting_span").removeClass("disabled");
                      $("span.voting_span").removeClass("active");
                    
                    $(".popup_overview_extra_content").append(result.value.data.voting_html);
                    
                    Swal.fire("Your Vote Removed!", "", "success");

                    console.log($("span.total_agree_vote_count_"+ report_table_id_val).text());
                  }
                }
                

                
              });

            }else{
              Swal.fire("No Vote found!");
            }
          
        }else{
          Swal.fire("No Vote found with this email !");
        }
        
      });
   
    
      })
    }

   


   
    
  });

});
