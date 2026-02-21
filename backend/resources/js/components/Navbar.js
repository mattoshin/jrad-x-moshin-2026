import React, {Fragment} from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faAlignLeft } from "@fortawesome/free-solid-svg-icons";
import { Navbar, Button, Nav } from "react-bootstrap";

import Cookies from 'universal-cookie';
class NavBar extends React.Component {
    constructor(){
      super();
      this.state={
          companyName:'',
              hexcode:'',
              imageUrl: '',
                  avatar:'',
                  username:'',
      }
  }
  UNSAFE_componentWillMount=e=>{
      const cookies = new Cookies();
      let user = cookies.get('user')
      this.setState({
          avatar:user.user.avatar,
          username:user.user.username
      });

  }

  render(){
      const { username, avatar }= this.state
  
    return (
      <Navbar
        className="navbar"
        expand
      >
        <Button className="toggle-button" onClick={this.props.toggle}>
          <FontAwesomeIcon icon={faAlignLeft} />
        </Button>
        <Navbar.Toggle aria-controls="responsive-navbar-nav" />
        <Navbar.Collapse id="responsive-navbar-nav">
          <div className="headerSub">
            <div id="greetingContainer">
                <p id="greeting" class="text-white">Welcome, {username}</p>
            </div>
            <Fragment class="">
              <div id="notificationBar" >
                  <div id="profileSection">
                      <a id="profileLink" class="row" >{username}</a>
                      <a id="logoutLink" class="row"  href="/logout">Logout</a>
                  </div>
                  <img id="profilePicture" width="3em" height="3em"  src={avatar}/>
              </div>
            </Fragment>
          </div>
        </Navbar.Collapse>
      </Navbar>
    );
  }
}

export default NavBar;
