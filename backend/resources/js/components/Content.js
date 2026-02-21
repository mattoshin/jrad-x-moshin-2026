import React from "react";
import classNames from "classnames";
import { Container } from "react-bootstrap";
import { BrowserRouter, Route, Routes, useLocation } from 'react-router-dom';
import ReactDOM from 'react-dom';
import Cookies from 'universal-cookie';
import NavBar from "./Navbar";
import ManagedMonitors from "./Pages/ManageMonitors/ManagedMonitor";
import AccountSetting from "./Pages/AccountSettings/AccountSetting";

class Content extends React.Component {
  constructor(props) {
    super(props);

    // Moblie first
    this.state = {
      isOpen: false,
      isMobile: true
    };

    this.previousWidth = -1;
  }

  updateWidth() {
    const width = window.innerWidth;
    const widthLimit = 576;
    const isMobile = width <= widthLimit;
    const wasMobile = this.previousWidth <= widthLimit;

    if (isMobile !== wasMobile) {
      this.setState({
        isOpen: !isMobile
      });
    }

    this.previousWidth = width;
  }

  /**
   * Add event listener
   */
  componentDidMount() {
    this.updateWidth();
    window.addEventListener("resize", this.updateWidth.bind(this));
  }

  /**
   * Remove event listener
   */
  componentWillUnmount() {
    window.removeEventListener("resize", this.updateWidth.bind(this));
  }

  toggle = () => {
    this.setState({ isOpen: !this.state.isOpen });
  };

  render() {
    return (
      <Container
        fluid
        className={classNames("content", { "is-open": this.props.isOpen })}
      >
        <NavBar toggle={this.props.toggle} />
        
        <div id="routes">
          <Routes>
            <Route toggle={this.toggle} isOpen={this.state.isOpen} path="/home" id="manageMonitors" element={<ManagedMonitors />}>
            </Route>
            <Route toggle={this.toggle} isOpen={this.state.isOpen} path="/account" id="accountSetting" element={<AccountSetting  />}/>
          </Routes>
        </div>
      </Container>
    );
  }
}

export default Content;
