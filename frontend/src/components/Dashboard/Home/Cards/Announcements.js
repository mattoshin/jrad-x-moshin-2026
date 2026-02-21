import { faFilter } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import AnnouncementsCards from "./AnnouncementsCards";

const Announcements = () => {
  return (
    <div className="main-cards-wrapper col-md-12 col-lg-4 p-3">
      <div className="main-card">
        <div className="main-wrapper-up">
          <h5 className="text-white align-items-center d-flex h-100">
            Announcements
          </h5>
        </div>
        <div className="main-wrapper-down announcements-down p-3">
          <AnnouncementsCards />
        </div>
      </div>
    </div>
  );
};
export default Announcements;
