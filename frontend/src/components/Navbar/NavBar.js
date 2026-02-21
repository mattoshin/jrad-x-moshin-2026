import React, { useState } from "react";
import { NavLink, Outlet } from "react-router-dom";
import "./NavBar.css";
import logo from "../../assets/logo.png";
function NavBar() {
  const [click, setClick] = useState(false);

  const handleClick = () => setClick(!click);
  return (
    <>
      <nav className="navbar">
        <div className="nav-container">
          <NavLink to="/" className="nav-logo">
            <div className="d-flex align-items-center">
              <img src={logo} width={70} height={70} alt="logo" />
              <h3 className="text-white mocean-text">Mocean</h3>
            </div>
          </NavLink>

          <ul className={click ? "nav-menu active" : "nav-menu"}>
            <li className="nav-item d-flex my-auto">
              <a
                style={{ color: "#8e92a7" }}
                href="https://discord.gg/F7syGdJMZq"
                activeclassname="active"
                className="nav-links nav-button text-white"
                onClick={handleClick}
              >
                Client Server
              </a>
            </li>
            {/* <li className="nav-item">
              <NavLink
                exact
                to="/about"
                activeclassname="active"
                className="nav-links"
                onClick={handleClick}
              >
                About
              </NavLink>
            </li>
            <li className="nav-item">
              <NavLink
                exact
                to="/products"
                activeclassname="active"
                className="nav-links"
                onClick={handleClick}
              >
                Products
              </NavLink>
            </li>
            <li className="nav-item">
              <NavLink
                exact
                to="/contact"
                activeclassname="active"
                className="nav-links"
                onClick={handleClick}
              >
                Contact Us
              </NavLink>
            </li> */}
            <li className="nav-item d-flex my-auto">
              <NavLink
                exact
                to="/login"
                activeclassname="active"
                className="nav-links nav-button"
                onClick={handleClick}
              >
                Dashboard
              </NavLink>
            </li>
          </ul>
          <div className="nav-icon-navbar" onClick={handleClick}>
            <i className={click ? "fas fa-times" : "fas fa-bars"}></i>
          </div>
        </div>
      </nav>
      <Outlet />
    </>
  );
}

export default NavBar;
