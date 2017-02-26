# Archive_DueOverview_SancoShipping from 2014
### An old project i made for my employer which helped keep track of overdue jobs on their vessels.

This software, known as DueOverview from now on, is a web application built with PHP and Javascript.

It uses bootstrap in the front, and laravel in the back. 

Also worth noting, it heavily relies on dropzonejs for drag'nDrop, and HighCharts for the fancy graphs.<br>
<img src="readme/php-logo.png" width="110px"><img src="readme/javascript-logo.png" width="90px"><img src="readme/logo-mysql.png" width="90px"><img src="readme/laravel-logo.png" width="90px"><img src="readme/bootstrap-logo.gif" width="90px">

<img src="readme/highcharts-logo.png" width="120px"><img src="readme/dropzone-logo.jpg" width="120px">


### start
1. DueOverview would generate an SQL string that the user would copy into a field in the maintenance software.

2. The maintenance software would then give you an xml file with all the data this software needed.

3. The user would then proceed to upload the xml files imply by draging the files into.

4. DueOverview would store all the information in its mySql database.

5. User would go to the overview page and see the statistics. 

![alt tag](readme/6cbb3bd0-e564-4458-8cbc-f8c53afb7ec4.gif)
