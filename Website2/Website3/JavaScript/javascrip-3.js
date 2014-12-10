
	/*var count= 0;*/

	function categoryAllOnClick(id)
	{
		idChecked= document.getElementById(id).checked;

		/*console.log(idChecked);*/

		shirtsChecked= document.getElementById("shirts").checked;
		chinosChecked= document.getElementById("chinos").checked;
		jeansChecked= document.getElementById("jeans").checked;
		suitsChecked= document.getElementById("suits").checked;
		blazersChecked= document.getElementById("blazers").checked;
		trousersChecked= document.getElementById("trousers").checked;


		if(id== "categoryAll")
		{
			document.getElementById("shirts").checked= idChecked;
			document.getElementById("chinos").checked= idChecked;
			document.getElementById("jeans").checked= idChecked;
			document.getElementById("suits").checked= idChecked;
			document.getElementById("blazers").checked= idChecked;
			document.getElementById("trousers").checked= idChecked;
		}
		else
			if((shirtsChecked== true) && (chinosChecked== true) && (jeansChecked== true) &&
				(suitsChecked== true) && (blazersChecked== true) && (trousersChecked== true))
			{
				document.getElementById("categoryAll").checked= true;
			}
			else
			{
				document.getElementById("categoryAll").checked= false;
			}
	}