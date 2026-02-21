import Announcements from "../Home/Cards/Announcements";
import Settings from "./MonitorCards/Settings";
import Monitors from "./MonitorCards/Monitors";
import { useNavigate, useParams, Navigate } from "react-router-dom";
import { useRef, useState } from "react";
import { useOnClickOutside } from "../../../helpers";
import { ToastContainer, toast } from "react-toastify";
import { cancelProduct } from "../../../api";

const ManageMonitors = () => {
  const [open, setOpen] = useState(false);
  const navigate = useNavigate();
  const { id } = useParams();
  const ref = useRef();
  useOnClickOutside(ref, () => setOpen(false));

  const cancelSubscription = async () => {
    setOpen(false)
    const cancelResponse = await cancelProduct(id);
    const url = `/cancel/${id}`;
    navigate(url);
  }

  return (
    <div className="p-5">
      <div className="row">
      {!open ? <></> : (
        <div className="background-blur">
          <div className="cancel-popup" style={{ zIndex: 1 }} ref={ref}>
            <p>Are you sure you want to cancel?</p>
            <div className="d-flex">
              <button
                style={{
                  color: "white",
                  width: "120px",
                  backgroundColor: "#00878C",
                  height: "32px",
                  border: "none",
                  fontWeight: "550",
                  borderRadius: "4px",
                  margin: "2px",
                }}
                onClick={() => cancelSubscription()}
              >
                Yes
              </button>
              <button
                style={{
                  color: "white",
                  width: "120px",
                  backgroundColor: "#00878C",
                  height: "32px",
                  border: "none",
                  fontWeight: "550",
                  borderRadius: "4px",
                  margin: "2px",
                }}
                onClick={() => setOpen(false)}
              >
                No
              </button>
            </div>
          </div>
        </div>
      )}
        <Settings 
        setOpen={setOpen}/>
        <Announcements />
        <Monitors />
      </div>
    </div>
  );
};
export default ManageMonitors;
