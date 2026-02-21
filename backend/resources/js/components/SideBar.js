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
  faTimes
} from "@fortawesome/free-solid-svg-icons";
import "bootstrap/dist/css/bootstrap.min.css";
import Cookies from 'universal-cookie';
import { Nav, Button, NavLink } from "react-bootstrap";

import classNames from "classnames";

class SideBar extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      isAdmin: false,
    }
  }
  componentDidMount(){
    const cookies = new Cookies();
        let users = cookies.get('user')
        this.setState({isAdmin:users.user.admin})
        
  }
  render() {
    return (
      <div className={classNames("sidebar", { "is-open": this.props.isOpen })}>
        <div className="sidebar-header">
          <Button
            variant="link"
            onClick={this.props.toggle}
            style={{ color: "#fff" }}
            className="mt-4">
            <FontAwesomeIcon icon={faTimes} pull="right" size="xs" />
          </Button>
          <h3>Mocean</h3>
        </div>
        <Nav className="flex-column pt-2">
        {window.location.pathname === '/home' ? 
          <Nav.Item>
            <Nav.Link href="/home">
              <div className="nav-icons navbar-home">
                <FontAwesomeIcon icon={faHome} className="mr-2"/>
              </div>
              <p id="navbar-text">Manage Monitor</p>
            </Nav.Link>
          </Nav.Item>
        : 
      
          <Nav.Item>
            <Nav.Link href="/home">
              <div className="nav-icon navbar-home">
                <FontAwesomeIcon icon={faHome} className="mr-2"/>
              </div>
              <p id="navbar-text">Manage Monitor</p>
            </Nav.Link>
          </Nav.Item>
       
        }
        {window.location.pathname === '/account' ?
          <Nav.Item>
            <Nav.Link href="/account">
              <div className="nav-icons navbar-account">
                <FontAwesomeIcon icon={faCog} className="mr-2" />
              </div>
              <p id="navbar-text">Account Settings</p>
            </Nav.Link>
          </Nav.Item>
          :
          <Nav.Item>
            <Nav.Link href="/account">
              <div className="nav-icon navbar-account">
                <FontAwesomeIcon icon={faCog} className="mr-2" />
              </div>
              <p id="navbar-text">Account Settings</p>
            </Nav.Link>
          </Nav.Item>
        }

        {window.location.pathname === '/account' ?
          <Nav.Item>
            <Nav.Link href="/account">
              <div className="nav-icons navbar-account">
                <FontAwesomeIcon icon={faCog} className="mr-2" />
              </div>
              <p id="navbar-text">Products</p>
            </Nav.Link>
          </Nav.Item>
          :
          <Nav.Item>
            <Nav.Link href="/account">
              <div className="nav-icon navbar-account">
                <FontAwesomeIcon icon={faCog} className="mr-2" />
              </div>
              <p id="navbar-text">Products</p>
            </Nav.Link>
          </Nav.Item>
        }
        {this.state.isAdmin ? 

         <Nav.Item>
            <Nav.Link href="/admin/users">
              <div className="nav-icon navbar-account">
              <FontAwesomeIcon icon={faHammer} className="mr-2" />
              </div>
              <p id="navbar-text">Admin</p>
            </Nav.Link>
          </Nav.Item>
          : null
        }


        </Nav>

      </div>
    );
  }
}

export default SideBar;
