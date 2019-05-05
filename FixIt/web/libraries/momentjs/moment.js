// Retrieve the format date method (that follows the given pattern) from the scheduler library
var formatDate = scheduler.date.date_to_str("%d-%m-%Y %H:%i:%s");

/**
 * Returns an Object with the desired structure of the server.
 *
 * @param {*} id
 * @param {*} useJavascriptDate
 */
function getFormatedEvent(id, useJavascriptDate){
    var event;

    // If id is already an event object, use it and don't search for it
    if(typeof(id) == "object"){
        event = id;
    }else{
        event = scheduler.getEvent(parseInt(id));
    }

    if(!event){
        console.error("The ID of the event doesn't exist: " + id);
        return false;
    }

    var start , end;

    if(useJavascriptDate){
        start = event.start_date;
        end = event.end_date;
    }else{
        start = formatDate(event.start_date);
        end = formatDate(event.end_date);
    }

    return {
        id: event.id,
        start_date : start,
        end_date : end,
        description : event.description,
        title : event.text
        user : event.userId
    };
}