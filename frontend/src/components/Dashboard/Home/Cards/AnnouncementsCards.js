import { 
  announcements as announcementsApi,
  getProductAnnouncement as getProductAnnouncementApi
} from "../../../../api";
import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

const AnnouncementsCards = () => {
  const [announcements, setAnnouncements] = useState([]);
  const { id } = useParams();
  const getData = async() => {
    if( !id ) {
      let announcementsData = await announcementsApi();
      setAnnouncements(announcementsData.data);
    } else {
      let announcementData = await getProductAnnouncementApi(id);
      setAnnouncements(announcementData.data);  
    }
  };

  useEffect(()=>{
    getData();
  }, []);
  return (
    <div
      className="p-2 text-break"
      style={{
        height: "auto",
        borderRadius: "7px"
      }}
    >
      {announcements.map((data)=>{
        return (
          <div className="d-block mb-4">
            <h6 className="mb-0" style={{ 
                // margin: "8px", 
                color: "#00878C", 
                fontWeight: "bold", 
                // textShadow: "2px 2px 4px #00878C",
                // backgroundImage: 'url(http://resources.guild-hosting.net/201604011348/themes/core/images/tag_fx/sparkle_teal.gif)',
                width: '115px'}}>
              Administrator:
            </h6>
            {/* <h6 className="text-white" style={{ fontSize: "10px" }}>
              Today 12:22 PM
            </h6> */}
            <p 
            style={{
              color: "rgb(160, 160, 160)",
              // backgroundColor: "rgba(24, 27, 36, 0.5)",
              // padding: "8px"
            }}
            >{data.announcement}</p>
          </div>
        )
      })}
    </div>
  );
};

export default AnnouncementsCards;
