// TODO: PHP code to get list of existing classes
courses = [[1111,'IB HL Trolling'],[1234,'PRE-IB Lolling'],[1245,'Regular Physics']];
/*
users[x][y][n][1] is semesterStatus (0 = both semesters, 1 = Fall only, 2 = Spring only)
x is block number
y is course id
n is student name
*/

$(document).ready(function(){
	$('body > table > tbody').append('<tr><td>'+createNewClassEntry(1)+'</td><td>'+createNewPeersList(1,1111)+'</td></tr>');
});

/*******************************************************************************
CLASS STRUCTURE
<form class="block" id="block#"> where # is from 1 to 8
<br>
Class:
<select class="classselect block#" id="block#select">
[generated class values]
</select>
<br>
(save button)
</form>
********************************************************************************
USERLIST STRUCTURE
People you have "[classname]" with:
<ul class="userlist">
</ul>
*******************************************************************************/

function createNewClassEntry(index) // Does not output entry, just returns structure
{
	courselist = '';
	for (i=0;i<courses.length;i++)
	{
		courselist += '<option value="'+courses[i][0]+'">'+courses[i][1]+'</option>'
	}
	return '<form class="block" id="block'+index+'">'+
		'<h3>Block '+index+'</h3>'+
		'Class:<br>'+
		'<select class="classselect block'+index+'" id="block'+index+'select">'+
		// TODO: append existing classes, for now this is static data
		courselist+
		'</select>'+
		'<br>'+
		'Or enter a course ID:<br>'+
		'<span class="wrap"><label for="block'+index+'cid" class="overlay"><span>Course ID</span></label>'+
		'<input class="input-text" id="block'+index+'cid"></span>'
		'<input type="submit" class="classsave block'+index+'" value="Save">';
		'</form>';
}

function createNewPeersList(index,crsid)
{
	// get data from PHP frontend, display
	// tmp: static
	return '<li>Herpina</li><li>Derpina</li>';
}

function createNewBlock(index)
{
}

// callbacks