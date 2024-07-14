// Document is ready
$(document).ready(function () {
  var companySymbolError = true;
  var emailError = true;
  var dateFromError = true;
  var dateToError = true;
  $('#accordion-chart').hide();

  $('#date-from').datepicker({ dateFormat: 'yy-mm-dd' });
  $('#date-to').datepicker({ dateFormat: 'yy-mm-dd' });

  var companySymbol = "";
  var dateFrom = "";
  var dateTo = "";

  var chart = null

	function validateCompanySymbol() {
		let usernameValue = $("#company-symbol").val();
		if (usernameValue.length == "") {
			$("#company-symbol-check").show();
			usernameError = false;
			return false;
		} else if (usernameValue.length < 2 || usernameValue.length > 6) {
			$("#company-symbol-check").show();
			$("#company-symbol-check").html("**length of username must be between 2 and 6");
			usernameError = false;
			return false;
		} else {
			$("#company-symbol-check").hide();
		}
	}

  function validateDateFrom() {
    let date = $("#date-from").val();
		if (date.length == "") {
      $("#date-from-valid").show();
      dateFromError = false;
      return false;
    } else {
      $("#date-from-valid").hide();
      dateFromError = true;
    }
  }

  function validateDateTo() {
    let date = $("#date-to").val();
    if (date.length == "") {
      $("#date-to-valid").show();
      dateFromError = false;
      return false;
    } else {
      $("#date-to-valid").hide();
      dateFromError = true;
    }
  }

  function validateEmail() {
    // Validate Email
    const email = document.getElementById("email");
    let regex =
    /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
    let s = email.value;
    if (regex.test(s)) {
      email.classList.remove("is-invalid");
      emailError = true;
    } else {
      email.classList.add("is-invalid");
      emailError = false;
    }
  }

	function buildPricesTableAndChart(data) {
    $('#accordion-chart').show();

    var $table = $('<table  class="table">');

    $table.append('<thead>').children('thead')
    .append('<tr />').children('tr').append('<th>Date</th><th>Open</th><th>High</th><th>Low</th><th>Close</th><th>Volume</th>');

    var $tbody = $table.append('<tbody />').children('tbody');
    data.prices.reverse();

    data.prices.forEach(element => {
         var date = new Date(element.date * 1000);
         $tbody.append('<tr />').children('tr:last')
             .append("<td>"+date.getFullYear() + '.' +  (date.getMonth() + 1) + '.' + date.getDate()+"</td>")
             .append("<td>"+element.open+"</td>")
             .append("<td>"+element.high+"</td>")
             .append("<td>"+element.low+"</td>")
             .append("<td>"+element.close+"</td>")
             .append("<td>"+element.volume+"</td>");
     });;

    $('#prices-table').empty()

    $table.appendTo('#prices-table');


    var openPrices = [];
    var closedPrices = [];
    var dates = [];

    data.prices.forEach(element => {
        openPrices.push(element.open);
        closedPrices.push(element.close);
        var date = new Date(element.date * 1000);
        dates.push(date.getFullYear() + '.' +  (date.getMonth() + 1) + '.' + date.getDate());
    });;



   if (null !== chart) {
      chart.destroy();
   }
   const ctx = document.getElementById('prices-chart');

   chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: dates,
        datasets: [{
           label: 'Closed price',
           data: closedPrices,
           fill: false,
           borderColor: 'rgb(75, 192, 192)'
         },{
            label: 'Open price',
            data: openPrices,
            fill: false,
            borderColor: 'rgb(160, 115, 150)'
          }]
      }
    });
	}

  function getHistoryData() {
     $.ajax({
        type: "GET",
        url: "/api/v1/histories",
        data: {
           companySymbol: companySymbol,
           dateFrom: dateFrom,
           dateTo: dateTo,
       },
        success: function (data) {
          buildPricesTableAndChart(data)
        },
         error: function (data) {
            alert(JSON.stringify(data.responseJSON.errors))
        }
    });
  }

  function errorsToString(data){
    var result = ""
    var errors = data.responseJSON.errors

    if (errors.companySymbol) {
      result += '<b>Company symbol</b>:<br>'
      errors.companySymbol.forEach(element => {
        result += element + '<br>'
      });
    }
    result += '<br>'

    if (errors.dateFrom) {
      result += '<b>Date from</b>:<br>'
      errors.dateFrom.forEach(element => {
        result += element + '<br>'
      });
    }
    result += '<br>'
    if (errors.dateTo) {
      result += '<b>Date to</b>:<br>'
      errors.dateTo.forEach(element => {
        result += element + '<br>'
      });
    }
    result += '<br>'

    return result
  }


  function sendEmail() {
       companySymbol = $("#company-symbol").val()
       dateFrom = $("#date-from").val()
       dateTo = $("#date-to").val()

       $.ajax({
          type: "POST",
          url: "/api/v1/emails",
          data: {
             companySymbol: companySymbol,
             email:  $("#email").val(),
             dateFrom: dateFrom,
             dateTo: dateTo,
         },
          success: function (data) {
             getHistoryData();
          },
          error: function (data) {
             Swal.fire({
               icon: "error",
               title: "Oops...",
               html: errorsToString(data),//JSON.stringify(data.responseJSON.errors)
               footer: 'Please change fields!'
             });
          }

      });
  }
	// Submit button
	$("#submitbtn").click(function () {
		validateCompanySymbol();
		validateEmail();
		validateDateTo();
		validateDateFrom();
		if (
			companySymbolError == true &&
			emailError == true &&
			dateFromError == true &&
			dateToError == true
		) {
		  sendEmail();
			return true;
		} else {
			return false;
		}
	});
});
