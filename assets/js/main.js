$(document).ready(function () {
  const url = "http://localhost/Gym-Management-System";

  // Login Admin

  $("#loginform").submit(function (event) {
    event.preventDefault();
    const emailOrUsername = $(
      '#loginform input[name="username_or_email"]'
    ).val();
    const password = $('#loginform input[name="password"]').val();

    $.ajax({
      url: url + "/php/login.php",
      method: "POST",
      data: { emailOrUsername, password },
      success: function (response) {
        if (response == "Success") {
          location.href = "./dashboard.php";
        } else {
          $(".error__message").html(response);
        }
      },
      error: function (XMLHTTPRequest) {
        console.log(XMLHTTPRequest.responeText);
      },
    });
  });

  // Add Member

  $("#addmember__form").submit(function (event) {
    event.preventDefault();

    const fname = $("#addmember__form input[name='fname']").val();
    const lname = $("#addmember__form input[name='lname']").val();
    const contact = $("#addmember__form input[name='contact']").val();
    const address = $("#addmember__form input[name='address']").val();
    const email = $("#addmember__form input[name='email']").val();
    const fee = $("#addmember__form input[name='fee']").val();

    $.ajax({
      url: url + "/php/add-member.php",
      method: "POST",
      data: { fname, lname, contact, address, email, fee },
      success: function (response) {
        if (response == "Success") {
          location.href = url + "/members.php";
        } else {
          $(".alert__message").html(response);
        }
      },
      error: function (XMLHTTPRequest) {
        console.log(XMLHTTPRequest.responeText);
      },
    });
  });

  // Update Member

  $("#update__member").on("show.bs.modal", function (event) {
    const button = $(event.relatedTarget);

    const memberid = button.data("id");
    const memberfname = button.data("fname");
    const memberlname = button.data("lname");
    const membercontact = button.data("contact");
    const memberemail = button.data("email");
    const memberaddress = button.data("address");
    const memberfee = button.data("fee");

    $("#update__member input[name='memberid']").val(memberid);
    $("#update__member input[name='fname']").val(memberfname);
    $("#update__member input[name='lname']").val(memberlname);
    $("#update__member input[name='contact']").val(membercontact);
    $("#update__member input[name='address']").val(memberaddress);
    $("#update__member input[name='email']").val(memberemail);
    $("#update__member input[name='fee']").val(memberfee);
  });

  $("#updatemember__from").submit(function (event) {
    event.preventDefault();

    const memberid = $("#update__member input[name='memberid']").val();
    const fname = $("#update__member input[name='fname']").val();
    const lname = $("#update__member input[name='lname']").val();
    const contact = $("#update__member input[name='contact']").val();
    const address = $("#update__member input[name='address']").val();
    const email = $("#update__member input[name='email']").val();
    const fee = $("#update__member input[name='fee']").val();

    $.ajax({
      url: url + "/php/edit-member.php",
      method: "POST",
      data: { memberid, fname, lname, contact, address, email, fee },
      success: function (response) {
        if (response == "Success") {
          location.href = url + "/members.php";
        } else {
          $(".alert__message").html(response);
        }
      },
      error: function (XMLHTTPRequest) {
        console.log(XMLHTTPRequest.responeText);
      },
    });
  });

  // Deactivate Member

  $("#deactivate__member").on("click", function (event) {
    event.preventDefault();

    const id = $(this).data("id");

    $.ajax({
      url: url + "/php/deactivate-member.php",
      method: "POST",
      data: { id },
      success: function (response) {
        if (response == "Success") {
          location.href = url + "/members.php";
        } else {
          $(".alert__message").html(response);
        }
      },
      error: function (XMLHTTPRequest) {
        console.log(XMLHTTPRequest.responeText);
      },
    });
  });

  // Activate Member

  $("#activate__member").on("click", function (event) {
    event.preventDefault();

    const id = $(this).data("id");

    $.ajax({
      url: url + "/php/activate-member.php",
      method: "POST",
      data: { id },
      success: function (response) {
        if (response == "Success") {
          location.href = url + "/members.php";
        } else {
          $(".alert__message").html(response);
        }
      },
      error: function (XMLHTTPRequest) {
        console.log(XMLHTTPRequest.responeText);
      },
    });
  });

  $("input[name='generatefee']").change(function () {
    const generatefee = $(this).val();

    if (generatefee == "allmembers") {
      $("#forsingle").attr("class", "hide");
    } else if (generatefee == "singlemember") {
      $("#forsingle").removeAttr("class", "hide");
    }
  });

  // Generate Fee

  $("#generatefee__btn").click(function (event) {
    event.preventDefault();

    const monthid = $("#generatefee__form select[name='feemonth']").val();
    const year = $("#generatefee__form select[name='feeyear']").val();
    const generatefee = $(
      "#generatefee__form input[name='generatefee']:checked"
    ).val();

    // For all Members

    if (generatefee == "allmembers") {
      $.ajax({
        url: url + "/php/generate-fee.php",
        method: "POST",
        data: { monthid, year },
        success: function (response) {
          if (response == "Success") {
            location.href = url + "/members.php";
          } else {
            $(".error__message").html(response);
            console.log(response);
          }
        },
        error: function (XMLHTTPRequest) {
          console.log(XMLHTTPRequest.responeText);
        },
      });
      // For Single Member
    } else if (generatefee == "singlemember") {
      const id = $("#generatefee__form input[name='memberid']").val();
      const name = $("#generatefee__form input[name='name']").val();

      $.ajax({
        url: url + "/php/single-generate.php",
        method: "POST",
        data: { monthid, year, id, name },
        success: function (response) {
          if (response == "Success") {
            location.href = url + "/members.php";
          } else {
            $(".error__message").html(response);
          }
        },
        error: function (XMLHTTPRequest) {
          console.log(XMLHTTPRequest.responeText);
        },
      });
    }
  });

  // Get Member data for payment

  $("#payment").on("show.bs.modal", function (event) {
    const button = $(event.relatedTarget);

    const memberid = button.data("id");
    $.ajax({
      url: url + "/php/get-member-data.php",
      method: "POST",
      data: { memberid },
      success: function (response) {
        $("#payment_body").html(response);
        var ActualAmount = 0;
        $(".totalamount").each(function () {
          ActualAmount += parseInt($(this).val());
          $("#totalamountsum").html(ActualAmount);
        });

        var DueAmount = 0;
        $(".due_fee").each(function () {
          DueAmount += parseInt($(this).val());
          $("#actualdueamount").html(DueAmount);
        });
      },
      error: function (XMLHTTPRequest) {
        console.log(XMLHTTPRequest.responeText);
      },
    });
  });

  // Sum of fee inputs

  $("#recievefeetable").on("input", ".txt-edit", function () {
    var calculated_total_sum = 0;

    $("#recievefeetable .txt-edit").each(function () {
      var get_textbox_value = $(this).val();
      if ($.isNumeric(get_textbox_value)) {
        calculated_total_sum += parseFloat(get_textbox_value);
      }
    });
    $("#TotalReceived").val(calculated_total_sum);
  });

  // Receive Fee

  $("#recievefee__btn").on("click", function (event) {
    event.preventDefault();

    var recieveamount = $(".txt-edit").val();

    if (recieveamount != 0) {
      $(".txt-edit").each(function () {
        const recieveFee = $(this).val();
        const feeId = $(this).data("id");
        const memberid = $(this).data("memberid");
        $.ajax({
          url: url + "/php/recieve-fee.php",
          method: "POST",
          data: { recieveFee, feeId, memberid },
          success: function (response) {
            if (response == "Success") {
              location.href = url + "/members.php";
            } else {
              // $(".error__message").removeClass("d-none");
              // $(".error__message").html(response);
              // setTimeout(function () {
              // $(".error__message").addClass("d-none");
              // }, 2000);
              comsole.log(response);
            }
          },
          error: function (XMLHTTPRequest) {
            console.log(XMLHTTPRequest.responeText);
          },
        });
      });
    } else {
      $(".error__message").removeClass("d-none");
      $(".error__message").html("Please write an amount");
      setTimeout(function () {
        $(".error__message").addClass("d-none");
      }, 2000);
    }
  });
});
