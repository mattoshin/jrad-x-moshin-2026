import React from "react";
import logo from './calender.png';
import filter from './Vector4.png';
import axios from 'axios'






class Annoucements extends React.Component{
    constructor(props){
        super(props);
        this.state={
            announcement:[],
            error:null
        };
    }

UNSAFE_componentWillMount=e=>{
    //https://ocean.cadash.net
        axios.get("http://localhost:8000/api/announcements")
        .then(res =>
            this.setState({
                announcement:res.data
        })
        )
        .catch((error) => {
            this.setState({
                error
            });
        });

    };


    render(){
            const { error, announcement } = this.state;
            const announcements = announcement.slice(0, 2).map((announcement) =>{
                        return(
                            <div id="announcementsTable">
                                <div id= "appointmentDesc" class="" ><div className="adminBlue">Admin:</div> {announcement.announcement}</div>
                            </div>
                        )
            })

        return(
            <div id="announcements" class=" text-white">
                <div class="">
                    <h6 id="announcementsTitle">Announcements</h6>
                </div>
                <div id="announcementContainer">
                    {announcements}
                   {/* <tr id="announcementsTable">
                        <td><img id="calender" class="" src={logo}></img></td>
                        <td id="date-time" class=" text-center pe-3 fs-6 pt-2 mt-2"><p>Today <br></br>12:00</p></td>
                        <td id= "appointmentDesc" class="">At nesciunt voluptatem. Dolor dolores eum aut sed. Omis alias est et adipisci earum beatae molestiae.</td>
                    </tr> */}
                </div>
                </div>
        )
    }
}


export default Annoucements
