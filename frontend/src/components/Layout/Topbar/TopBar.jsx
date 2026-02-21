import {
  faPowerOff,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { useState } from "react";
import "./styles.css?v=1.001";
import { Nav, Button } from "react-bootstrap";
import { faBell, faEnvelope } from "@fortawesome/free-regular-svg-icons";
import { faAlignLeft } from "@fortawesome/free-solid-svg-icons";
import { Outlet } from "react-router-dom";
import { useNavigate } from "react-router-dom";
import { useRef } from "react";
import { useOnClickOutside } from "../../../helpers";

const TopBar  = ({ isSidebarOpen, setIsSidebarOpen }) => {
  const [open, setOpen] = useState(false);
  const navigate = useNavigate();
  const ref = useRef();
  useOnClickOutside(ref, () => setOpen(false));

  return (
    <>
      <div className="topbar mb-3">
        <Button 
          className="toggle-button" 
          variant="link"
          style={{
            color: 'white'
          }}
          onClick={() => {
            setIsSidebarOpen(!isSidebarOpen);
          }}>
          <FontAwesomeIcon icon={faAlignLeft} />
        </Button>
        <div className="d-flex my-auto ">
          {window.location.pathname === "/home" ? (
          <h3 className="m-0 text-white topbar-text">Welcome, {localStorage.getItem("username")}</h3>
          ) : ""}
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
            alt="topbar"
            onClick={() => setOpen(true)}
          />
          <div className="d-flex align-self-center ms-3">
            {!open ? <></> : (
              <div className="position-relative" ref={ref}>
                <div className="profile-popup" style={{ zIndex: 1 }}>
                  <Nav.Link href="/account" className="popup-item d-flex">
                    <p
                      style={{
                        color: "#fff",
                        fontSize: "15px",
                        fontWeight: "bold",
                      }}
                    >
                      Account Settings
                    </p>
                  </Nav.Link>
                  <Nav.Link href="/switch-business" className="popup-item d-flex">
                    <p
                      style={{
                        color: "#fff",
                        fontSize: "15px",
                        fontWeight: "bold",
                      }}
                    >
                      Switch server
                    </p>
                  </Nav.Link>
                  <Nav.Link className="popup-item logout-item d-flex" onClick={()=>{
                    navigate("/logout");
                  }}>
                    <FontAwesomeIcon
                      className="my-auto"
                      color="#6F767E"
                      icon={faPowerOff}
                      size="sm"
                    />
                    <p
                    style={{fontWeight: "600", paddingLeft: "10px", paddingBottom: "6px"}}>Log Out</p>
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
