<!DOCTYPE html>
<html lang="en">
    <head>
        <title> My Calendar </title>
        <link rel="stylesheet" href="search.css">
        <?php include("includes/templates/header.php") ?>
        <script>
            function callFunc (postparams, completion)
            {
                let xhttp = new XMLHttpRequest();
                let formData = new FormData();
                for (each in postparams) formData.append (each, postparams[each]);
                xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4 && this.status == 200)
                    {
                        completion (this.responseText);
                    }
                }
                xhttp.open("POST", "/data/datafunc.php")
                xhttp.send(formData);
            }

            var letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                           'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            var weekdays = ["SU", "MO", "TU", "WE", "TH", "FR", "SA"];

            var cal = ics();

            function resetCal(){
                cal = ics();
            }

            function createICS(){
                var input = document.getElementById("search-bar").value;
                
                var hasLetters = false;
                
                for(var i=0; i<letters.length && !hasLetters; i++){
                    if(input.includes(letters[i])) hasLetters=true;
                }

                //Hard coded course for now
                var course = {
                    name: "Imperative Programming",
                    code: "15122",
                    
                    events: [
                    {
                        id: "1",
                        type: "OH",
                        start: "9/26/2020 5:30 pm",
                        end: "9/26/2020 6:30 pm",
                        repeat: true,
                        repeatday: 6,
                        repeatinterval: 1,
                        zoomlink: "LINK1"
                    },
                    {
                        id: "2",
                        type: "OH",
                        start: "9/26/2020 6:30 pm",
                        end: "9/26/2020 7:30 pm",
                        repeat: true,
                        repeatday: 6,
                        repeatinterval: 2,
                        zoomlink: "LINK2"
                    },
                    {
                        id: "3",
                        type: "OH",
                        start: "9/26/2020 7:30 pm",
                        end: "9/26/2020 8:30 pm",
                        repeat: true,
                        repeatday: 6,
                        repeatinterval: 4,
                        zoomlink: "LINK3"
                    },
                    {
                        id: "4",
                        type: "OH",
                        start: "9/26/2020 8:30 pm",
                        end: "9/26/2020 9:30 pm",
                        repeat: false,
                        repeatday: 6,
                        repeatinterval: 1,
                        zoomlink: "LINK4"
                    }
                ]};
                if(hasLetters){
                    //Course name
                    let params = {
                        funcName: "getCourseByCourseName",
                        course_name: input
                    }

                    function setCourse(responseText){
                        console.log(responseText);
                        let json = JSON.parse(responseText);
                        course = json;
                    }

                    callFunc(params, setCourse);
                }
                else{
                    //Course Number
                    let params = {
                        funcName: "getCourseByCourseCode",
                        course_code: input
                    }

                    function setCourse(responseText){
                        console.log(responseText);
                        let json = JSON.parse(responseText);
                        course = json;
                    }

                    callFunc(params, setCourse);
                }

                for(var i = 0; i < course["events"].length; i++){
                    var curr = course["events"][i];
                    if(!curr["repeat"]){
                        cal.addEvent(course["code"].concat(" ", course["labNumber"], course["lectureNumber"], curr["type"], " (", course["name"], ")"), curr["zoomlink"], "Carnegie Mellon University", curr["start"], curr["end"]);
                    }
                    else{
                        var rrule = {
                            freq: "WEEKLY",
                            until: "12/31/2020",
                            interval: curr["repeatinterval"],
                            byday: [weekdays[curr["repeatday"]]]
                        }
                        cal.addEvent(course["code"].concat(" ", course["labNumber"], course["lectureNumber"], curr["type"], " (", course["name"], ")"), curr["zoomlink"], "Carnegie Mellon University", curr["start"], curr["end"], rrule);
                    }
                }

                
            }

            function downloadCal(){
                cal.download();
            }

        </script>
        <div class="search">
            <input id="search-bar" type="text" placeholder="Search Course" class="searchCourse"/>
        </div>
                
        <button onclick="resetCal()">Reset Calendar</button>
        <button onclick="createICS()">Add to Calendar</button>
        <button onclick="downloadCal()">Download Calendar</button>
    </body>
</html>