import {
  faPowerOff,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useState } from "react";
import "./styles.css";
import { Nav } from "react-bootstrap";
import { faBell, faEnvelope } from "@fortawesome/free-regular-svg-icons";
import { Outlet } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import { useRef } from "react";
import { useOnClickOutside } from "../../../helpers";

const TopBar = () => {
  const [open, setOpen] = useState(false);
  const navigate = useNavigate();
  const ref = useRef();
  useOnClickOutside(ref, () => setOpen(false));

  return (
    <>
      <div className="topbar">
        <div className="d-flex my-auto ">
          <h3 className="m-0 text-white topbar-text"></h3>
        </div>
        <div className="d-flex">
          {/* <div className="topbar-icons">
            <FontAwesomeIcon icon={faBell} size="lg" color="white" />
          </div>
          <div className="new-notification-icon" />
          <div className="topbar-icons ms-3">
            <FontAwesomeIcon icon={faEnvelope} size="lg" color="white" />
          </div>
          <div className="new-message-icon" /> */}
          <img
            className="topbar-image"
            src={localStorage.getItem("avatar")}
            onClick={() => setOpen(true)}
          />
          <div className="d-flex align-self-center ms-3">
            {!open ? <></> : (
              <div className="position-relative" ref={ref}>
                <div className="profile-popup" style={{ zIndex: 1 }}>
                  <Nav.Link href="/switch-business" className="popup-item">
                    <p
                      style={{
                        color: "#fff",
                        fontSize: "15px",
                        fontWeight: "bold",
                      }}
                    >
                      Switch Business
                    </p>
                  </Nav.Link>
                  <Nav.Link className="popup-item logout-item d-flex text-center justify-content-center" onClick={()=>{
                    navigate("/logout");
                  }}>
                    <FontAwesomeIcon
                      className="my-auto"
                      color="rgb(153 153 153)"
                      icon={faPowerOff}
                      size="sm"
                    />
                    <p style={{ color: "#fff", fontWeight: "bold" }}>Log Out</p>
                  </Nav.Link>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>

      <Outlet />
    </>
  );
};
export default TopBar;
