import React, { useState } from "react";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faHome,
  faBriefcase,
  faPaperPlane,
  faQuestion,
  faImage,
  faCog,
  faHammer,
  faTimes,
  faBox,
  faPieChart,
  faClose,
  faArrowRight,
  faArrowLeft,
  faFileInvoice,
} from "@fortawesome/free-solid-svg-icons";
import "bootstrap/dist/css/bootstrap.min.css";
import Cookies from "universal-cookie";
import { Nav, Button, NavLink } from "react-bootstrap";
import classNames from "classnames";
import "./SidebarStyles.css";
import logo from "../../assets/logo.png";

class SideBar extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      isAdmin: false,
    };
  }
  //   componentDidMount() {
  //     const cookies = new Cookies();
  //     let users = cookies.get("user");
  //     this.setState({ isAdmin: users.user.admin });
  //   }
  render() {
    return (
      <div
        className={classNames("sidebar", {
          "is-open": this.props.isSidebarOpen,
        })}
      >
        <div className="sidebar-header">
          <Button
            variant="link"
            onClick={() => {
              this.props.setIsSidebarOpen(!this.props.isSidebarOpen);
            }}
            style={{ color: "#fff" }}
            className="mt-4"
          >
            {this.props.isSidebarOpen ? (
              <FontAwesomeIcon icon={faArrowLeft} pull="right" size="xs" />
            ) : (
              <FontAwesomeIcon icon={faArrowRight} pull="right" size="xs" />
            )}
          </Button>
          {/* <h3>Mocean</h3> */}

          <img src={logo} width={80} height={80} />
        </div>
        {window.location.pathname === "/home" ? (
          <Nav.Item>
            <Nav.Link href="/home">
              <div className="nav-icons navbar-home">
                <FontAwesomeIcon icon={faHome} className="mr-2" />
              </div>
              <p id="navbar-text">Home</p>
            </Nav.Link>
          </Nav.Item>
        ) : (
          <Nav.Item>
            <Nav.Link href="/home">
              <div className="nav-icon navbar-home">
                <FontAwesomeIcon
                  style={{ color: "#FF8096" }}
                  icon={faHome}
                  className="mr-2"
                />
              </div>
              <p id="navbar-text">Home</p>
            </Nav.Link>
          </Nav.Item>
        )}
        <Nav className="flex-column pt-2">
          {window.location.pathname === "/manage" ? (
            <Nav.Item>
              <Nav.Link href="/manage">
                <div className="nav-icons navbar-manage">
                  <FontAwesomeIcon icon={faPieChart} className="mr-2" />
                </div>
                <p id="navbar-text">Manage Monitor</p>
              </Nav.Link>
            </Nav.Item>
          ) : (
            <Nav.Item>
              <Nav.Link href="/manage">
                <div className="nav-icon navbar-manage">
                  <FontAwesomeIcon
                    style={{ color: "#73C6A3" }}
                    icon={faPieChart}
                    className="mr-2"
                  />
                </div>
                <p id="navbar-text">Manage Monitor</p>
              </Nav.Link>
            </Nav.Item>
          )}
          {window.location.pathname === "/account" ? (
            <Nav.Item>
              <Nav.Link href="/account">
                <div className="nav-icons navbar-account">
                  <FontAwesomeIcon icon={faCog} className="mr-2" />
                </div>
                <p id="navbar-text">Account Settings</p>
              </Nav.Link>
            </Nav.Item>
          ) : (
            <Nav.Item>
              <Nav.Link href="/account">
                <div className="nav-icon navbar-account">
                  <FontAwesomeIcon
                    style={{ color: "#FDAE60" }}
                    icon={faCog}
                    className="mr-2"
                  />
                </div>
                <p id="navbar-text">Account Settings</p>
              </Nav.Link>
            </Nav.Item>
          )}

          {window.location.pathname === "/products" ? (
            <Nav.Item>
              <Nav.Link href="/products">
                <div className="nav-icons navbar-product">
                  <FontAwesomeIcon icon={faBox} className="mr-2" />
                </div>
                <p id="navbar-text">Product</p>
              </Nav.Link>
            </Nav.Item>
          ) : (
            <Nav.Item>
              <Nav.Link href="/products">
                <div className="nav-icon navbar-product">
                  <FontAwesomeIcon
                    style={{ color: "#38C0FF" }}
                    icon={faBox}
                    className="mr-2"
                  />
                </div>
                <p id="navbar-text">Products</p>
              </Nav.Link>
            </Nav.Item>
          )}
          {window.location.pathname === "/invoices" ? (
            <Nav.Item>
              <Nav.Link href="/invoices">
                <div className="nav-icons navbar-invoices">
                  <FontAwesomeIcon icon={faFileInvoice} className="mr-2" />
                </div>
                <p id="navbar-text">Invoices</p>
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
                <p id="navbar-text">Invoices</p>
              </Nav.Link>
            </Nav.Item>
          )}
          {this.state.isAdmin ? (
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
  }
}

export default SideBar;
