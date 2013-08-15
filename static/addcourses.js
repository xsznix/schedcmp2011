numCourses = 0;

function createNewCourseEntry(index) // Returns formatting for a new course entry
{
	return '<h3>Course '+index+'</h3>'+
	'<span id="course'+index+'-wrapper">'+
		'<span class="wrap">'+
			'<label for="course'+index+'-block" class="overlay"><span>Block Number</span></label>'+
			'<input id="course'+index+'-block" class="input-text" name="block[]">'+
		'</span><br>'+
		'<span class="wrap">'+
			'<label for="course'+index+'-name" class="overlay"><span>Course Name</span></label>'+
			'<input id="course'+index+'-name" class="input-text" name="coursename[]">'+
		'</span><br>'+
		'<span class="wrap">'+
			'<label for="course"'+index+'-number" class="overlay"><span>Course Number (4 digit)</span></label>'+
			'<input id="course'+index+'-number" class="input-text" name="coursenumber[]">'+
		'</span><br>'+
		'<span class="wrap">'+
			'<select id="course'+index+'-semester" name="semesterstatus[]">'+
			'<option value="">Choose Semester...</option>'+
			'<option value="0">Both Semesters</option>'+
			'<option value="1">First Semester</option>'+
			'<option value="2">Second Semester</option>'+
			'</select>'+
	'</span>'+
	'<span><input type="button" id="course'+index+'-remove" value="Remove this course" onclick="removeCourseEntry('+index+')"></span>'+
	'<br></span>';
}

function spawnNewCourseEntry()
{
	course = createNewCourseEntry(++numCourses);
	$('#courses-wrapper').append(course);
	inputs = $('#course'+numCourses+'-block, #course'+numCourses+'-name, #course'+numCourses+'-number');
	inputs.each(function(index, input){
		styleinput(index, input);
	});
}

function removeCourseEntry(index)
{
	// Remove course
	$('#course'+index+'-wrapper').prev().remove();
	$('#course'+index+'-wrapper').remove();
	// Renumber everything below it.
	i = index; i++;
	while (i <= numCourses)
	{
		// This is extremely inefficient way
		inputs = $('#course'+i+'-block, #course'+i+'-name, #course'+i+'-number');
		labels = $('label[for=course'+i+'-block], label[for=course'+i+'-name], label[for=course'+i+'-number]');
		span = $('#course'+i+'-wrapper');
		removebutton = $('#course'+i+'-remove');
		$(inputs[0]).attr('id','course'+(i-1)+'-block');
		$(inputs[1]).attr('id','course'+(i-1)+'-name');
		$(inputs[2]).attr('id','course'+(i-1)+'-number');
		$(labels[0]).attr('for','course'+(i-1)+'-block');
		$(labels[1]).attr('for','course'+(i-1)+'-name');
		$(labels[2]).attr('for','course'+(i-1)+'-number');
		span.attr('id','course'+(i-1)+'-wrapper');
		// geh i hate javascript workarounds. can't pass i to onclick, so let's just reconstruct the element itself
		removebutton.parent().html('<input type="button" id="course'+(i-1)+'-remove" value="Remove this course" onclick="removeCourseEntry('+(i-1)+')">');
		span.prev().html('Course '+(i-1));
		i++;
	}
	numCourses--;
	return 0;
}

function validate()
{
	form = $('#courses');
	for (i=1;i<=numCourses;i++)
	{
		error = validateCourseEntry(i);
		if (!!error) { $('#message').html(error); return false; }
	}
	return true;
}
function validateCourseEntry(index)
{
	entry = $('#course'+index+'-wrapper');
	inputs = $('#course'+index+'-block, #course'+index+'-name, #course'+index+'-number');
	semester = $('#course'+index+'-semester');
	if (inputs[0].value==null||inputs[0].value==''||isNaN(inputs[0].value)) { return 'Course '+index+': Invalid block number'; }
	if (inputs[1].value==null||inputs[1].value=='') { return 'Course '+index+': Please enter the course name'; }
	if (inputs[2].value==null||inputs[2].value==''||isNaN(inputs[2].value)||inputs[2].value.length!=4) { return 'Course '+index+': Invalid course ID'; }
	if (semester[0].value==null||!semester[0].value) { return 'Course '+index+': Please select a semester(s)'; }
	return false;
}

$(document).ready(function(){spawnNewCourseEntry();});