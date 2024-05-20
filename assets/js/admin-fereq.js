/* eslint-disable no-undef */


jQuery(document).ready(function ($) {

    $(document).ready(function() {

      $('.fereq-color-picker').wpColorPicker();

      jQuery('#manageRequestTable').DataTable({
        select: true
      });

        $("span.see_report").on('click', function() {
            var dataId = $(this).attr('data-id');
            $("#push_report_data_into_div").html("");
            $("div.custom-model-wrap").css({
                "height": "600px "
              })
              $("div.loading_for_show_report").fadeIn("slow");
            $("div.show_report_popup").addClass('model-open');
         
            $.ajax({
                // eslint-disable-next-line no-undef
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'show_report_content_on_popup_action', // Ajax action name
                    // eslint-disable-next-line no-undef
                    nonce: ajax_data.nonce1 ,
                    dataId,
                },
                success(response) {
                   
                    if(response.success) {
                        $("#push_report_data_into_div").html(response.data.html);
                        $("div.custom-model-wrap").css({
                            "height": "auto ",
                            "max-height": "600px",
                          })
                        $("div.loading_for_show_report").fadeOut("slow");


                        $("button.update_status_btn").on("click", function() {
                          var report_id = $("#report_table_id_val").val();
                          var update_status_select = $("#update_status_select").val();

                          if(update_status_select == ""){
                            $("p.update_status_msg").text("Please select any");
                          }else{
                            $("p.update_status_msg").text("");
                          }

                          if(update_status_select != ""){
                            $(this).html('Wait <i class="fa fa-spinner fa-spin"></i>');
                            $.ajax({
                              // eslint-disable-next-line no-undef
                              url: ajax_data.ajax_url,
                              type: 'POST',
                              data: {
                                  action: 'report_status_update_action', // Ajax action name
                                  // eslint-disable-next-line no-undef
                                  nonce: ajax_data.nonce5 ,
                                  report_id,
                                  update_status_select
                              },
                              success(response) {
                               if(response.data.status){
                          
                               
                                  $("button.update_status_btn").text('Updated');
                                  $(".div_after_td span.update_status_" + dataId).text(response.data.updated_status);
                                  if(response.data.updated_status ==="inprogress"){
                                    $("span.show_updated_report_status").text("In Progress");
                                    $("span.show_updated_report_status").addClass("sugg");
                                    $("span.show_updated_report_status").removeClass("done"); 
                                    $(".div_after_td span.update_status_" + dataId).addClass("report_status_inprogress");
                                    $(".div_after_td span.update_status_" + dataId).addClass("report_status_exploring");
                                    $(".div_after_td span.update_status_" + dataId).removeClass("report_status_done");                                                                   
                                  }else if(response.data.updated_status ==="done"){
                                    $("span.show_updated_report_status").text("Done");
                                    $("span.show_updated_report_status").addClass("done");
                                    $("span.show_updated_report_status").removeClass("sugg");
                                    $(".div_after_td span.update_status_" + dataId).addClass("report_status_done");
                                    $(".div_after_td span.update_status_" + dataId).removeClass("report_status_exploring");
                                    $(".div_after_td span.update_status_" + dataId).removeClass("report_status_inprogress");
                                    
                                  }else{
                                    $("span.show_updated_report_status").text("Exploring");
                                    $("span.show_updated_report_status").addClass("sugg");
                                    $("span.show_updated_report_status").removeClass("done");
                                    $(".div_after_td span.update_status_" + dataId).addClass("report_status_exploring");
                                    $(".div_after_td span.update_status_" + dataId).removeClass("report_status_inprogress");
                                    $(".div_after_td span.update_status_" + dataId).removeClass("report_status_done");
                                  
                                  }
                                
                               }
                              },
                              error(xhr, status, error) {
        
                                console.log(error);
                              }
                            });

                          }

                        });
                    }
                  },
                  error(xhr, status, error) {
        
                    console.log(error);
                  }
            });

          });

          $("span.see_report_comment").on("click", function (e) {
            var dataId = $(this).attr('data-id');
            $("#push_report_data_into_div").html("");
            $("div.custom-model-wrap").css({
                "height": "500px "
              })
              $("div.loading_for_show_report").fadeIn("slow");
            $("div.show_report_popup").addClass('model-open');

            $.ajax({
                // eslint-disable-next-line no-undef
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'show_report_comment_on_popup_action', // Ajax action name
                    // eslint-disable-next-line no-undef
                    nonce: ajax_data.nonce2 ,
                    dataId,
                },
                success(response) {
                   
                    if(response.success) {
                        $("#push_report_data_into_div").html(response.data.html);
                        comment_trash_attachment_event();
                        $("div.custom-model-wrap").css({
                            "height": "auto ",
                            "max-height": "500px",
                          })
                        $("div.loading_for_show_report").fadeOut("slow");
                        $("button.comment_btn").on("click", function(e) {
                            $(this).text("Wait....");
                            var cTextarea = $("#comment_textarea").val();
                            var comment_email_field = $("#comment_email_field").val();
                            var comment_name_field = $("#comment_name_field").val();
                            var report_table_id_val = $("#report_table_id_val").val();
                            var requestFrom ="admin";
                            var comment_type ="comment";
      
                            if(comment_email_field == ""){
                              $("p.comment_result_massage").text("Email are required");
                            }else if(cTextarea == ""){
                              $("p.comment_result_massage").text("Fields are required");
                            }else{
                              $("p.comment_result_massage").text("");
                            }
      
                            if(comment_email_field != "" && cTextarea != ""){
                              $.ajax({
                                // eslint-disable-next-line no-undef
                                url: ajax_data.ajax_url,
                                type: 'POST',
                                data: {
                                    action: 'comment_store_database_action', // Ajax action name
                                    // eslint-disable-next-line no-undef
                                    nonce: ajax_data.nonce4 ,
                                    comment_email_field,
                                    cTextarea,
                                    commentator_name: comment_name_field,
                                    comment_type,
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

                                    comment_trash_attachment_event();
                                  }
                                 
      
                                },
                                error(xhr, status, error) {
            
                                  console.log(error);
                              }
                              });
                            }
      
      
                          })
      
                    }
                  },
                  error(xhr, status, error) {
        
                    console.log(error);
                  }
            });

          });

          function validateEmail(email) {
            // Regular expression pattern for email validation
            var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return pattern.test(email);
        }

          $("span.see_report_upvote").on("click", function(e) {
                var dataId = $(this).attr('data-id');
                $("#push_report_data_into_div").html("");
                $("div.custom-model-wrap").css({
                    "height": "500px "
                })
                $("div.loading_for_show_report").fadeIn("slow");
                $("div.show_report_popup").addClass('model-open');
                     $.ajax({
                // eslint-disable-next-line no-undef
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'show_upvote_on_popup_action', // Ajax action name
                    // eslint-disable-next-line no-undef
                    nonce: ajax_data.nonce3 ,
                    dataId,
                },
                success(response) {
                   
                    if(response.success) {
                        $("#push_report_data_into_div").html(response.data.html);
                        $("div.custom-model-wrap").css({
                            "height": "auto ",
                            "max-height": "500px",
                          })
                        $("div.loading_for_show_report").fadeOut("slow");

                        
                    }
                  },
                  error(xhr, status, error) {
        
                    console.log(error);
                  }
            });
          });

          $("div.close_report_popup, div.close_report_popup_overly").click(function(){
            $("div.show_report_popup").removeClass('model-open');
            window.location.reload();
          });

          $("span.delete_report").on("click", function(){
            var dataId = $(this).attr('data-id');
          
            // eslint-disable-next-line no-undef
            Swal.fire({
              title: "Do you want to delete it?",
              showDenyButton: false,
              showCancelButton: true,
              confirmButtonText: "Delete",
              denyButtonText: `Don't save`
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                // eslint-disable-next-line no-undef
                // Swal.fire("Saved!", "", "success");
                $("div.loading_for_delete").fadeIn('slow');
                  $.ajax({
                    // eslint-disable-next-line no-undef
                    url: ajax_data.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'deleted_the_report_table_row_action', // Ajax action name
                        // eslint-disable-next-line no-undef
                        nonce: ajax_data.nonce6 ,
                        dataId,
                    },
                    success(response) {
                        
                        if(response.data.status) {
                           
                            $("tr.table_row_id_"+ dataId).hide();
                            $("div.loading_for_delete").fadeOut('slow');
                            // eslint-disable-next-line no-undef
                            Swal.fire("Deleted!", "", "success");
    
                            
                        }
                      },
                      error(xhr, status, error) {
            
                        console.log(error);
                      }
                });
              } else if (result.isDenied) {
                // eslint-disable-next-line no-undef
                Swal.fire("Changes are not saved", "", "info");
              }
            });
          });

          
          $(".add_new_plugin_btn").on("click", function(){
            $(".add_new_plugin_popup").addClass("model-open");
            $(".add_new_plugin_popup div.custom-model-wrap").css({
              "height": "auto "
          })
          });

          $("div.close-btn.close_add_new_popup").on("click", function() {
            $(".add_new_plugin_popup").removeClass("model-open");
            window.location.reload();
          });

          $(".plugin_add_save_btn").on("click", function() {
               var plugin_name = $("#plugin_name").val();
              if(plugin_name == "") {
                $(".status_msg").text("Plugin name is required");
              }
              $(".loading_for_add_plugin").fadeIn("slow");
              $.ajax({
                // eslint-disable-next-line no-undef
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_plugin_name_to_database', // Ajax action name
                    // eslint-disable-next-line no-undef
                    nonce: ajax_data.nonce7 ,
                    plugin_name,
                },
                success(response) {
                  
                    $(".status_msg").text(response.data.status);
                    $(".status_msg").addClass("success");
                    $(".loading_for_add_plugin").fadeOut("slow");
                    $("#plugin_name").val("");
                  },
                  error(xhr, status, error) {
        
                    console.log(error);
                  }
            });

          });

          $(".edit_plugin_name").on("click", function(){
            $(".edit_added_plugin_popup").addClass("model-open");
            $("#edit_added_plugin_wrap").addClass("active");
            $("#edit_added_plugin").html("");
           
            $(".loading_for_add_plugin").fadeIn("slow");
            var plugin_id = $(this).attr("data-id");
            $.ajax({
              // eslint-disable-next-line no-undef
              url: ajax_data.ajax_url,
              type: 'POST',
              data: {
                  action: 'edit_plugin_name_to_database', // Ajax action name
                  // eslint-disable-next-line no-undef
                  nonce: ajax_data.nonce8 ,
                  plugin_id
              },
              success(response) {
                
                 

                  $("#edit_added_plugin").html(response.data.html);
                  $("#edit_added_plugin_wrap").removeClass("active");
                  $(".loading_for_add_plugin").fadeOut("slow");

                   
                  $(".plugin_name_edit_btn").on("click", function(){
                    var edited_plugin_name = $(".edited_plugin_name").val();
                    $(".loading_for_add_plugin").fadeIn("slow");
                        $.ajax({
                          // eslint-disable-next-line no-undef
                          url: ajax_data.ajax_url,
                          type: 'POST',
                          data: {
                              action: 'edit_plugin_name_save_to_database', // Ajax action name
                              // eslint-disable-next-line no-undef
                              nonce: ajax_data.nonce9 ,
                              edited_plugin_name,
                              plugin_id
                          },
                          success(response) {
                             
                              if(response.data.status){
                                $(".status_msg").text("Plugin name updated successfully");
                              $(".status_msg").addClass("success");
                              }
                              $(".loading_for_add_plugin").fadeOut("slow");
                            },
                            error(xhr, status, error) {
                  
                              console.log(error);
                            }
                      });
                  });
                },
                error(xhr, status, error) {
      
                  console.log(error);
                }
          });
          
          });

          $("span.edited_plugin_name_delete").on("click", function(){
            var plugin_id = $(this).attr('data-id');
          
            // eslint-disable-next-line no-undef
            Swal.fire({
              title: "Do you want to delete it?",
              showDenyButton: false,
              showCancelButton: true,
              confirmButtonText: "Delete",
              denyButtonText: `Don't save`
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                // eslint-disable-next-line no-undef
                // Swal.fire("Saved!", "", "success");
                $("div.loading_for_add_plugin_delete").fadeIn('slow');
                  $.ajax({
                    // eslint-disable-next-line no-undef
                    url: ajax_data.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'edited_plugin_name_deleted_action', // Ajax action name
                        // eslint-disable-next-line no-undef
                        nonce: ajax_data.nonce10 ,
                        plugin_id,
                    },
                    success(response) {
                        
                        if(response.data.status) {
                           
                            $("tr.plugin_table_row_id_"+ plugin_id).hide();
                            $("div.loading_for_add_plugin_delete").fadeOut('slow');
                            // eslint-disable-next-line no-undef
                            Swal.fire("Deleted!", "", "success");
                            
    
                            
                        }
                      },
                      error(xhr, status, error) {
            
                        console.log(error);
                      }
                });
              } else if (result.isDenied) {
                // eslint-disable-next-line no-undef
                Swal.fire("Changes are not saved", "", "info");
              }
            });
          });


          function comment_trash_attachment_event(){
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
              var requestFrom = "admin" ;
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
                                    commenttype,
                                    requestFrom
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
                      
                      if (result.isConfirmed) {
                        if(result.value.data.status){
                          $("ul.push_comment_into_ul").html(result.value.data.comment_html);
                          $("b.comment_updated_status_" + reportId).text(result.value.data.total_count_comment);
                          Swal.fire("Comment Deleted Successfull!");
                          setTimeout(() => {
                                    
                                    comment_trash_attachment_event();
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
      
           
    });

});