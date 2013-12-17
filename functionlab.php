<?php

function outputall()
{

	print "<div class='one'>";
		foreach($_GET as $key=>$val)
		{
			if(is_array($val))
			{
				foreach($val as $item)
				{
					print "$key -- $item</br>";
				}
			}
			else
			{
				print "$key -- $val<br/>";
			}

		}
	print "</div>";

}

?>
