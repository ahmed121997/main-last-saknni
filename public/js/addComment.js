var commentWrapper = $('#display_comment')[0];
// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('add-comment');
// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\AddComment', function (data) {
    console.log(data,'ggggggggggggggggggggggooooooooooooooooooooooooooddddddddddddddddddddddddddddddddd');
    commentWrapper.append(" " +
        "<div class=\"display-comment\">\n" +
        "        <strong>"+ data.user_id +"</strong>\n" +
        "        <p>"+ data.comment_body +"</p>\n" +
        "        <a class=\"replay ml-3\" href=\"\" id=\"reply\">replay</a>\n" +
        "        <form class=\"replay-form\" method=\"post\" action=\"/comments\">\n" +
        "            @csrf\n" +
        "            <div class=\"form-group custom-control-inline w-75\">\n" +
        "                <input type=\"text\" name=\"body\" class=\"form-control\" />\n" +
        "                <input type=\"hidden\" name=\"property_id\" value=\""+data.property_id+"\" />\n" +
        "                <input type=\"hidden\" name=\"parent_id\" value=\""+data.comment_id +"\" />\n" +
        "            </div>\n" +
        "            <div class=\"form-group custom-control-inline w-20\">\n" +
        "                <input type=\"submit\" class=\"add-replay btn btn-warning\" value=\"Reply\" />\n" +
        "            </div>\n" +
        "            <p class=\"error-replay text-danger\"></p>\n" +
        "        </form></div>");
});
