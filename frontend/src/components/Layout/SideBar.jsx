import React, { useState } from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faHome,
  faCog,
  faHammer,
  faShoppingBag,
  faBox,
  faArrowRight,
  faArrowLeft,
  faFileInvoice,
  faTimes
} from "@fortawesome/free-solid-svg-icons";
import "bootstrap/dist/css/bootstrap.min.css";
import { Nav, Button } from "react-bootstrap";
import classNames from "classnames";
import "./SidebarStyles.css?v=1.002";
import logo from "../../assets/logo.png";
import { useNavigate } from "react-router-dom";

const SideBar = ({ isSidebarOpen, setIsSidebarOpen }) => {
  const [isAdmin, setIsAdmin] = useState(false);
  const navigate = useNavigate();

  return (
    <div
      className={classNames("sidebar", {
        "is-open": isSidebarOpen,
      })}
    >
      <div className="sidebar-header">
        <Button
          variant="link"
          onClick={() => {
            setIsSidebarOpen(!isSidebarOpen);
          }}
          style={{ color: "#fff", marginRight: "20px", marginLeft: "-50px" }}
        >
            <FontAwesomeIcon icon={faTimes} pull="right" size="xs" />
        </Button>
        {/* <h3>Mocean</h3> */}

        <img src={logo} width={80} height={80} alt="logo" />
      </div>
      {window.location.pathname === "/home" ? (
        <Nav.Item>
          <Nav.Link href="/home">
              <div className="navbar-row active">
                <div className="nav-icons navbar-home">
                  <FontAwesomeIcon icon={faHome} className="mr-2" />
                </div>
                <p id="navbar-text">Home</p>
              </div>
          </Nav.Link>
        </Nav.Item>
      ) : (
        <Nav.Item>
          <Nav.Link href="/home">
            <div className="navbar-row">
              <div className="nav-icon navbar-home">
                <FontAwesomeIcon
                  icon={faHome}
                  className="mr-2"
                />
              </div>
              <p id="navbar-text">Home</p>
            </div>
          </Nav.Link>
        </Nav.Item>
      )}
      <Nav className="flex-column pt-2">
        {window.location.pathname === "/active-products" || window.location.pathname.indexOf('manage') > -1 ? (
          <Nav.Item>
            <Nav.Link href="/active-products">
              <div className="navbar-row active">
                <div className="nav-icons navbar-manage">
                  <FontAwesomeIcon icon={faBox} className="mr-2" />
                </div>
                <p id="navbar-text">Active Products</p>
              </div>
            </Nav.Link>
          </Nav.Item>
        ) : (
          <Nav.Item>
            <Nav.Link href="/active-products">
              <div className="navbar-row">
                <div className="nav-icon navbar-manage">
                  <FontAwesomeIcon
                    icon={faBox}
                    className="mr-2"
                  />
                </div>
                <p id="navbar-text">Active Products</p>
              </div>
            </Nav.Link>
          </Nav.Item>
        )}
        {/* <h1 onClick={() => navigate("/manage")}>Test</h1> */}

        {window.location.pathname === "/products" ? (
          <Nav.Item>
            <Nav.Link href="/products">
              <div className="navbar-row active">
                <div className="nav-icons navbar-product">
                  <FontAwesomeIcon icon={faShoppingBag} className="mr-2" />
                </div>
                <p id="navbar-text">Product Store</p>
              </div>
            </Nav.Link>
          </Nav.Item>
        ) : (
          <Nav.Item>
            <Nav.Link href="/products">
              <div className="navbar-row">
                <div className="nav-icon navbar-product">
                  <FontAwesomeIcon
                    icon={faShoppingBag}
                    className="mr-2"
                  />
                </div>
                <p id="navbar-text">Product Store</p>
              </div>
            </Nav.Link>
          </Nav.Item>
        )}
        {/* {window.location.pathname === "/invoices" ? (
          <Nav.Item>
            <Nav.Link href="/invoices">
              <div className="nav-icons navbar-invoices">
                <FontAwesomeIcon icon={faFileInvoice} className="mr-2" />
              </div>
              <p id="navbar-text">Billing</p>
            </Nav.Link>
          </Nav.Item>
        ) : (
          <Nav.Item>
            <Nav.Link href="/invoices">
              <div className="nav-icon navbar-invoices">
                <FontAwesomeIcon
                  style={{ color: "#00878C" }}
                  icon={faFileInvoice}
                  className="mr-2"
                />
              </div>
              <p id="navbar-text">Billing</p>
            </Nav.Link>
          </Nav.Item>
        )} */}

        {window.location.pathname === "/account" ? (
          <Nav.Item>
            <Nav.Link href="/account">
              <div className="navbar-row active">
                <div className="nav-icons navbar-account">
                  <FontAwesomeIcon icon={faCog} className="mr-2" />
                </div>
                <p id="navbar-text">Account Settings</p>
              </div>
            </Nav.Link>
          </Nav.Item>
        ) : (
          <Nav.Item>
            <Nav.Link href="/account">
              <div className="navbar-row">
                <div className="nav-icon navbar-account">
                  <FontAwesomeIcon
                    icon={faCog}
                    className="mr-2"
                  />
                </div>
                <p id="navbar-text">Account Settings</p>
              </div>
            </Nav.Link>
          </Nav.Item>
        )}
        {isAdmin ? (
          <Nav.Item>
            <Nav.Link href="/admin/users">
              <div className="nav-icon navbar-account">
                <FontAwesomeIcon icon={faHammer} className="mr-2" />
              </div>
              <p id="navbar-text">Admin</p>
            </Nav.Link>
          </Nav.Item>
        ) : null}
      </Nav>
    </div>
  );
};

export default SideBar;
