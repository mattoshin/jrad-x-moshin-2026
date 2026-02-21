import React, {useState, useEffect, Fragment} from "react";
import {Link} from "react-router-dom";
import { BellIcon, MenuIcon, XIcon, InboxIcon } from '@heroicons/react/outline';
import { ChevronDownIcon } from "@heroicons/react/solid";
import ReactDOM from "react-dom";
import 'bootstrap/dist/css/bootstrap.min.css';
import { Container, Navbar,Button } from "react-bootstrap";
import Cookies from 'universal-cookie';

class Header extends React.Component{
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
    handleClick=e=>{
        window.localStorage.clear();
        cookies.remove("user", {path: "/", domain:'mocean.info'}) 
           alert('you have been logged out :)')
    }

    render(){
        const { username, avatar }= this.state

    return(
<>
            
      <Button color="info" onClick={toggleSidebar}>
        <FontAwesomeIcon icon={faAlignLeft} />
      </Button>
      <NavbarToggler onClick={toggleTopbar} />
            <div id="headerSub">
                <div id="greetingContainer">
                    <p id="greeting" class="text-white">Welcome, {username}</p>
                </div>
                <Fragment class="">
                    <div id="notificationBar" >
                        <div id="profileSection">
                            <a id="profileLink" class="row" >{username}</a>
                            <a id="logoutLink" href="logout" onClick={this.handleClick} class="row"  >Logout</a>
                        </div>
                        <img id="profilePicture" width="3em" height="3em"  src={avatar}/>


                    </div>
                </Fragment>
            </div>
            </>
    )
}
}
export default Header
/*
if(document.getElementById('bodycontainer')){
    ReactDOM.render(<Header/>, document.getElementById('bodycontainer'))
} */

