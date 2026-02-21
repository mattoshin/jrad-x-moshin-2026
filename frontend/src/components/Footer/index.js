import { Row, Col, Button, Stack, Container } from "react-bootstrap";

import animateScrollTo from "animated-scroll-to";
import logo from "../../assets/logo.png";
const Footer = () => {
  return (
    <Container>
      <Row style={{ margin: "50px 0px" }}>
        <Col sm={12} md={3}>
          <div className="footer__company  footer-links-wrapper">
            <a
              style={{
                marginLeft: "2px",
                textDecoration: "none",
                fontSize: "18px",
                fontWeight: "bolder",
              }}
              href="#home"
              className="footer__logo d-flex align-items-center"
            >
              <img src={logo} width={60} height={60} />
              <h5 className="text-white mocean-text">Mocean</h5>
            </a>
            <p
              style={{
                color: "#fff",
                width: "100%",
                display: "flex",
                justifyContent: "center",
                alignItems: "center",
                color: "#56569e",
              }}
            >
              Premier Information Services
            </p>
          </div>
        </Col>
        <Col
          className="footer-links-wrapper"
          style={{
            display: "flex",
            justifyContent: "center",
            textAlign: "left",
          }}
          sm={12}
          md={3}
        >
          <div className="footer__item">
            <h4 className="footer__item-title">Quick links</h4>
            <ul className="footer__list">
              <li className="footer__list-item">
                {window.location.pathname === "/products" ? (
                  <a
                  onClick={() => {
                    let el = document.getElementById("starting-div");
                    animateScrollTo(el, { speed: 590 });
                  }}
                  className="footer__list-item"
                >
                  Home
                </a>
                ) : (
                  <a href="/home" className="footer__list-item">
                  Home
                </a>
                )}
                
              </li>
              <li className="footer__list-item">
                <a href="/dashboard" className="footer__list-item">
                  Dashboard
                </a>
              </li>
              <li className="footer__list-item">
                <a
                  href="https://discord.gg/F7syGdJMZq"
                  className="footer__list-item"
                >
                  Client Server
                </a>
              </li>
              {/* <li className="footer__list-item"> <a href="#about" className="footer__list-item">About</a>
                    </li>
                    <li className="footer__list-item"><a href="#portfolio" className="footer__list-item">Case Studies</a>
                    </li>
                    <li className="footer__list-item"><a href="#contact" className="footer__list-item">Get in Touch</a></li> */}
            </ul>
          </div>
        </Col>
        <Col
          className="footer-links-wrapper"
          style={{
            display: "flex",
            justifyContent: "center",
            textAlign: "left",
          }}
          sm={12}
          md={3}
        >
          <div className="footer__item">
            <h4 className="footer__item-title"> Resources </h4>
            <ul className="footer__list">
              <li className="footer__list-item">
                {" "}
                <a href="/privacy-policy" className="footer__list-item">
                  Privacy
                </a>
              </li>
              <li className="footer__list-item">
                {" "}
                <a href="/terms-and-conditions" className="footer__list-item">
                  Terms & Condition
                </a>
              </li>
            </ul>
          </div>
        </Col>
        <Col
          className="footer-links-wrapper"
          style={{
            display: "flex",
            justifyContent: "center",
            textAlign: "left",
          }}
          sm={12}
          md={3}
        >
          <div className="footer__item">
            <h4 className="footer__item-title"> Support </h4>
            <ul className="footer__list">
              <li className="footer__list-item">
                {" "}
                <a href="#" className="footer__list-item">
                  Contact Us
                </a>
              </li>
              <li className="footer__list-item">
                {" "}
                <a href="#" className="footer__list-item">
                  Learn More
                </a>
              </li>
              <li className="footer__list-item">
                <a href="#" className="footer__list-item">
                  FAQ
                </a>
              </li>
            </ul>
          </div>
        </Col>
        <Col sm={12}>
          <p className="footer__rights">© All the rights are reserved </p>
        </Col>
      </Row>
    </Container>
  );
};
export default Footer;
