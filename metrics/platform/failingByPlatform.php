<?php

////////////////////////////////////////////////////////////////////////////////
//File:     execution.php
//Author:   Chad Rosen
//Purpose:  The page builds the detailed test case execution frame
////////////////////////////////////////////////////////////////////////////////

require_once("../../functions/header.php");

  session_start();
  doDBConnect();
  doHeader();
?>

<h2>Failing Test Cases By Platform Container</h2>

<?

$sqlPlatCon = "select id,name from platformcontainer where projId=" . $_SESSION['project'];
$resultPlatCon = mysql_query($sqlPlatCon);

while ($myrowPlatCon = mysql_fetch_row($resultPlatCon)) 
{ 
	
	$sqlPlatform = "select id,name from platform where containerId=" . $myrowPlatCon[0];
	$resultPlatform = mysql_query($sqlPlatform);

	if(mysql_num_rows($resultPlatform) > 0)
	{
		echo "<b>Container: </b>" . $myrowPlatCon[1] . "<br>";

		while ($myrowPlatform = mysql_fetch_row($resultPlatform)) 
		{ 	
			$sqlResults = "select tcid,buildId,platformList,result,dateRun,runBy,title from platformresults,testcase where (platformList like '%," . $myrowPlatform[0] . ",%' or platformList like '" . $myrowPlatform[0] . ",%' or platformList like '%," . $myrowPlatform[0] . "') and tcid=id and result='f' order by buildId";

			//echo $sqlResults;
			$resultPlatformResults = mysql_query($sqlResults);

			if(mysql_num_rows($resultPlatformResults) > 0)
			{
				echo "<blockquote><b>Platform: </b>" . $myrowPlatform[1] . "<br><br>";
				echo "<table width='100%' class='mainTable'>";
				echo "<tr><td class='userinfotable'><b>tcid</td>";
				echo "<td class='userinfotable'><b>Build</td>";
				echo "<td class='userinfotable'><b>Result</td>";
				echo "<td class='userinfotable'><b>Date</td>";
				echo "<td class='userinfotable'><b>Run By</td></tr>";
				
				while ($myrowResults = mysql_fetch_row($resultPlatformResults)) 
				{ 
					echo "<tr>";
					echo "<td>" . $myrowResults[6] . "</td>";
					echo "<td>" . $myrowResults[1] . "</td>";
					echo "<td>" . $myrowResults[3] . "</td>";
					echo "<td>" . $myrowResults[4] . "</td>";
					echo "<td>" . $myrowResults[5] . "</td>";
					echo "</tr>";				
				}
				
				echo "</table>";
			}

			echo "</blockquote>";
		}
	}
}

//$myrowPlatCon = mysql_fetch_row($resultPlatCon);

/*
		
$sql = "select component.id, component.name from component,project where project.id = " . $_SESSION['project'] . " and component.projid = project.id order by name";

$comResult = mysql_query($sql);

while ($myrowCOM = mysql_fetch_row($comResult)) 
{ 
	echo "<b>Component:</b> " . $myrowCOM[1] . "<br>";
	//display all the components until we run out
			
	//Here I create a query that will grab every category depending on the component the user picked

	$catResult = mysql_query("select category.id, category.name from component,category where component.id = " . $myrowCOM[0] . " and component.id = category.compid order by CATorder,category.id",$db);
			
	while ($myrowCAT = mysql_fetch_row($catResult)) 
	{  
		echo "<blockquote><b>Category:</b> " . $myrowCAT[1];

		$sqlTC = "select testcase.id, title, mgttcid from testcase where catid=" . $myrowCAT[0] . " order by mgttcid";

		$resultTC = mysql_query($sqlTC);

		while ($myrowTC = mysql_fetch_row($resultTC)) 
		{  
			echo "<blockquote><b>Test Case:</b> " . $myrowTC[2] . " " . $myrowTC[1] . "</blockquote>";

			$sqlResult = "select buildId, platformList, result, dateRun from platformresults where tcid=" . $myrowTC[0] . " order by buildId";

			$resultResult = mysql_query($sqlResult);

			echo "<blockquote>";
			echo "<table width='100%' class='mainTable'>";
			

			if(mysql_num_rows($resultResult) > 0)
			{	
				echo "<tr><td class='userinfotable'><b>Build</td>";
				echo "<td class='userinfotable'><b>Platforms</td>";
				echo "<td class='userinfotable'><b>Result</td>";
				echo "<td class='userinfotable'><b>Date Ran</td></tr>";
			}
			else
			{
				echo "<tr><td class='userinfotable'><b>No Results For This Test Case</td></tr>";
			}

			while ($myrowResult = mysql_fetch_row($resultResult)) 
			{
				echo "<tr>";
				echo "<td>" . $myrowResult[0] . "</td>";
				echo "<td>";

				$platformNameArray = explode(",",$myrowResult[1]);
		
				foreach ($platformNameArray as $platformId)
				{	
					$sqlPlatformName = "select name from platform where id=" . $platformId;
					$platformNameRow = mysql_fetch_row(mysql_query($sqlPlatformName)); //Run the query
					
					echo $platformNameRow[0] . " ";
				}
				
				echo "</td>";
				echo "<td>" . $myrowResult[2] . "</td>";
				echo "<td>" . $myrowResult[3] . "</td>";
				echo "</tr>";
			}

			echo "</table>";

			echo "</blockquote>";

		}

		echo "</blockquote>";
			
	}

}

*/