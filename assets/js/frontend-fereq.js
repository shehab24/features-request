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
                    var searchText = "people agree with this";
                    var listItemText = $(this).text().toLowerCase();
                    var match = listItemText.indexOf(searchText.toLowerCase()) > -1;
                    if (match) {
                        $(this).show(); // Show the element if it matches the criteria
                    } else {
                        $(this).hide(); // Hide the element if it doesn't match the criteria
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
                    $("select.agree_disagree_select").on("change", function(){
                      const value =  $(this).val();
          
                      if(value == 'agree' || value =='disagree'){
                        $("div.agree_disagree_hidden_div").fadeIn(100);
                      }else{
                        $("div.agree_disagree_hidden_div").fadeOut(100);
                      }
          
                    });

                    //  voting process 
                    $("button.vote_btn").on("click", function(){
                      var email_value = $("#voting_email_field").val();
                      var textArea = $("#hidden_div_content").val();
                      var select = $("#agree_disagree_select").val();
                      var report_table_id_val = $("#report_table_id_val").val();
                      var keep_me_posted = $("#keep_me_posted").val();

                      if(!validateEmail(email_value)){
                              $(".submittes_result_massage").text("Email are required");
                      }else if(textArea == ""){
                        $(".submittes_result_massage").text("Field are required");
                      }else{
                        $(".submittes_result_massage").text("");
                      }
 
                      if(validateEmail(email_value) && textArea != ""){
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
                              $("span.after_voting_done_msg").text("You have Voted");
                              $("span.total_agree_vote_count_"+ dataId).text(response.data.total_agree_voting );
                              $("span.total_disagree_vote_count_"+ dataId).text(response.data.total_disagree_voting );
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
                      $(this).text("Wait....");
                      var cTextarea = $("#comment_textarea").val();
                      var comment_email_field = $("#comment_email_field").val();
                      var report_table_id_val = $("#report_table_id_val").val();
                      var requestFrom ="publicUser";
                      if(!validateEmail(comment_email_field)){
                        $("p.comment_result_massage").text("Email are required");
                      }else if(cTextarea == ""){
                        $("p.comment_result_massage").text("Fields are required");
                      }else{
                        $("p.comment_result_massage").text("");
                      }

                      if(validateEmail(comment_email_field) && cTextarea != ""){
                        $.ajax({
                          // eslint-disable-next-line no-undef
                          url: ajax_data.ajax_url,
                          type: 'POST',
                          data: {
                              action: 'comment_store_database_action', // Ajax action name
                              nonce: ajax_data.nonce8 ,
                              comment_email_field,
                              cTextarea,
                              report_table_id_val,
                              requestFrom
                          },
                          success(response) {
                            if(response.data.status){
                              $("p.comment_result_massage").addClass("success");
                              $("button.comment_btn").text("Comment");
                              $("b.comment_updated_status_" + dataId).text(response.data.commenting_details);
                              $("p.comment_result_massage").text("Comment added successfully");
                              $("ul.push_comment_into_ul").html(response.data.comment_html);
                              $("#comment_textarea").val("");
                              $("#comment_email_field").val("");
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

    

  

   


   
    
  });

});
