
//-------------- ALL 全部分析Function ------------------
function google_an_all(view_id) {
	var all_an=new Array();
	//---- 每周使用人數 ----
	var an_week={'week': queryReports_e(view_id, '7daysAgo', 'today', 'ga:sessions')};
	//---- 每月使用人數 ----
	var an_month={'month': queryReports_e(view_id, '30daysAgo', 'today', 'ga:sessions')} ;
	//---- 總使用人數 ----
	var an_total={'total': queryReports_e(view_id, '2016-04-01', 'today', 'ga:sessions')} ;
	//---- 性別 ----
	var an_sex={'sex': queryReports(view_id, '2016-04-01', 'today', 'ga:sessions', 'ga:userGender')} ;
	//---- 年齡 ----
	var an_years={'years': queryReports(view_id, '2016-04-01', 'today', 'ga:sessions', 'ga:userAgeBracket')} ;
	//---- 媒體 ----
	var an_media={'media': queryReports(view_id, '2016-04-01', 'today', 'ga:sessions', 'ga:deviceCategory')} ;
	//---- 熱門事件點擊 ----
	var an_event={'event': queryReports(view_id, '2016-04-01', 'today', 'ga:uniqueEvents', 'ga:eventCategory')} ;
	//---- 流量來源 ----
	var an_source={'source':queryReports(view_id, '2016-04-01', 'today', 'ga:sessions', 'ga:sourceMedium')};
	//---- 地區 ----
	var an_city={'city': queryReports(view_id, '2016-04-01', 'today', 'ga:sessions', 'ga:city')} ;
	//---- 網站停留時間-年齡層 ----
	var an_timeOut={'timeOut': queryReports(view_id, '2016-04-01', 'today', 'ga:avgTimeOnPage', 'ga:userAgeBracket')} ;
	//---- 每日瀏覽人數 ----
	var an_date={'date': queryReports(view_id, '30daysAgo', 'today', 'ga:sessions', 'ga:date')} ;
	//all_an.concat(an_week, an_month, an_total, an_sex, an_years, an_media, an_event, an_source, an_city, an_timeOut, an_date);
	console.log(an_week);
	console.log(an_sex);
	console.log(an_date);
}

	  // Replace with your view ID.
		//var VIEW_ID = '149822707';

		// Query the API and print the results to the page.
		//--------------------- 指標+維度 ---------------------
		function queryReports(view_id, startDate, endDate, expression, dimensions) {
		  gapi.client.request({
		    path: '/v4/reports:batchGet',
		    root: 'https://analyticsreporting.googleapis.com/',
		    method: 'POST',
		    body: {
		      reportRequests: [
		        {
		          viewId: view_id,
		          dateRanges: [
		            {
		              startDate: startDate,
		              endDate: endDate
		            }
		          ],
		          metrics: [
		            { expression: expression }
		          ],
		          dimensions:[
                    { name: dimensions }
		          ]
		        }
		      ]
		    }
		  }).then(displayResults, console.error.bind(console));
		}

        //--------------------- 指標 ---------------------
		function queryReports_e(view_id, startDate, endDate, expression) {
		  gapi.client.request({
		    path: '/v4/reports:batchGet',
		    root: 'https://analyticsreporting.googleapis.com/',
		    method: 'POST',
		    body: {
		      reportRequests: [
		        {
		          viewId: view_id,
		          dateRanges: [
		            {
		              startDate: startDate,
		              endDate: endDate
		            }
		          ],
		          metrics: [
		            { expression: expression }
		          ]
		        }
		      ]
		    }
		  }).then(displayResults, console.error.bind(console));
		}

	function displayResults(response) {
		  //var formattedJson = JSON.stringify(response.result, null, 2);
		  //document.getElementById('query-output').value = formattedJson;
		  //console.log(  response.result.reports[0].data.rows );
		  // console.log(response.result.reports[0].data.rows[0].dimensions[0]);
		  // console.log(response.result.reports[0].data.rows[0].metrics[0].values[0]);
          
          return response.result.reports[0].data.rows;
		}