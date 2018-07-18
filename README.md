# DueOverview_SancoShipping from 2014

A web application used to keep track of TM-Master v2 overdue maintenance jobs.

It uses bootstrap in the front, laravel in the back, and is built with PHP and Javascript 

Also worth noting, it relies heavily on dropzonejs for drag'n Drop, and HighCharts for the fancy graphs.<br>
<img src="readme/php-logo.png" width="110px"><img src="readme/javascript-logo.png" width="90px"><img src="readme/logo-mysql.png" width="90px"><img src="readme/laravel-logo.png" width="90px"><img src="readme/bootstrap-logo.gif" width="90px">

<img src="readme/highcharts-logo.png" width="120px"><img src="readme/dropzone-logo.jpg" width="120px">


### start
1. DueOverview generates an SQL string that the user copies into a field in the maintenance software.

2. The maintenance software then gives you an xml file with all the data DueOverview needs.

3. The user then proceeds to upload the xml files into DueOverview simply by draging the files onto the browser window.

4. DueOverview stores all the information in its own mySql database.

5. User would go to the overview page and to see the statistics. 

![alt tag](readme/6cbb3bd0-e564-4458-8cbc-f8c53afb7ec4.gif)
