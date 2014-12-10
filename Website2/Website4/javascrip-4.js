
	var count= 0;

	function checkboxOnClick(id)
	{
		idChecked= document.getElementById(id).checked;

		console.log(idChecked);

		xChecked= document.getElementById("x").checked;
		yChecked= document.getElementById("y").checked;
		zChecked= document.getElementById("z").checked;

		if(id== "selectAll")
		{
			document.getElementById("x").checked= idChecked;
			document.getElementById("y").checked= idChecked;
			document.getElementById("z").checked= idChecked;
		}
		else
		if((xChecked== true) && (yChecked== true) && (zChecked== true))
		{
			document.getElementById("selectAll").checked= true;
		}
		else
		{
			document.getElementById("selectAll").checked= false;
		}
	}