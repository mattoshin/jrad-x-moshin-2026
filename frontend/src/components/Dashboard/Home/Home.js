import ActiveProd from "./Cards/ActiveProd";
import Announcements from "./Cards/Announcements";
import Invoices from "./Cards/Invoices";
import CardInfo from "./Cards/CardInfo";
import "./styles.css";

const DashboardHome = () => {
  return (
    <div className="main-content-wrapper">
      <div className="row m-0">
        <ActiveProd />
        <Announcements />
        <Invoices />
        <CardInfo />
      </div>
    </div>
  );
};
export default DashboardHome;
