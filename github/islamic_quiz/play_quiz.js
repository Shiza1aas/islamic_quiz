// alert("Hello from Javascript")

var a = document.getElementById('A');
var b = document.getElementById('B');
var c = document.getElementById('C');
var d = document.getElementById('D');
var register = document.getElementById('register');

register.addEventListener( "submit", CheckForm );

function CheckForm(e)
{
	if (!( a.checked || b.checked || c.checked || d.checked))
	{
		alert("Choose an answer.");
		e.preventDefault();
	}
	
}

