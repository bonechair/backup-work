$(function(){
$("a.vote_up").click(function(){
the_id = $(this).attr('id');
the_id_array = the_id.split(':');
	var compnum;
	var agreed;
	var deserved;
	the_id = the_id_array[1]+":"+the_id_array[2];
	compnum = the_id_array[1];
	agreed = the_id_array[3];
	agreed++;
	deserved = the_id_array[4];
$.ajax({
type: "POST",
data: "action=vote_up&id="+the_id,
url: "php/votes.php",
success: function(msg)
{
document.getElementById('a1votes_count'+compnum).innerHTML = '<span class="voted"><img src="images/voted.png" width="16" height="16" alt="Up" border="0"/><a>'+agreed+'</a></span>';
document.getElementById('a2votes_count'+compnum).innerHTML = '<span class="voted"><img src="images/voted_neg.png" width="16" height="16" alt="Down" border="0"/><a>'+deserved+'</a></span>';
}
});
});
$("a.vote_down").click(function(){
the_id = $(this).attr('id');
the_id_array = the_id.split(':');
	var compnum;
	var agreed;
	var deserved;
	the_id = the_id_array[1]+":"+the_id_array[2];
	compnum = the_id_array[1];
	agreed = the_id_array[3];
	deserved = the_id_array[4];
	deserved++;
$.ajax({
type: "POST",
data: "action=vote_down&id="+the_id,
url: "php/votes.php",
success: function(msg)
{
document.getElementById('a1votes_count'+compnum).innerHTML = '<span class="voted"><img src="images/voted.png" width="16" height="16" alt="Up" border="0"/><a>'+agreed+'</a></span>';
document.getElementById('a2votes_count'+compnum).innerHTML = '<span class="voted"><img src="images/voted_neg.png" width="16" height="16" alt="Down" border="0"/><a>'+deserved+'</a></span>';
}
});
});
});