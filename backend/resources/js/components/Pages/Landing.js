import React from "react";
import ReactDOM from 'react-dom';
import { Row, Col, Button, Stack } from 'react-bootstrap';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import {
  faHome,
  faBriefcase,
  faPaperPlane,
  faQuestion,
  faImage,
  faCog,
  faHammer,
  faTimes
} from "@fortawesome/free-regular-svg-icons";
import { 
  faFacebook,
  faTwitter,
  faDiscord
} from "@fontawesome/free-brands-svg-icons";
import './landing.css';


export const Landing = () => {
  return (
    <div className="content-container">
      <Row>
        <Col lg={6} xs={12}>
          <Stack className='welc-text-stack'>
            <div className='welcome-text'>WELCOME TO MOCEAN</div>
            <div className='hero-title'>Advanced NFT</div>
            <div className='hero-title'>Growth Platform</div>
            <div className='hero-description'>Anim ad nostrud tempor mollit eu laboris duis laborum qui minim aute eu. Sint sit deserunt adipisicing laboris laborum culpa do ipsum adipisicing commodo et et. Adipisicing aute cillum veniam quis laboris aliqua laborum incididunt sint.</div>
            <Row>
            <Col lg={3}><Button className='welc-btn'>Join Now</Button></Col>
            <Col><div className='learn-more'><a href="#">Learn more</a></div></Col>
            </Row>
            
          </Stack>
        </Col>
        <Col lg={5} xs={12}>
          <div className="dashboard-image">
            <div className="dashboard-header">
              <div className="dashboard-row">
                <div className="dashboard-circle"/>
                <div className="dashboard-circle"/>
                <div className="dashboard-circle"/>
              </div>
            </div>
          </div>
        </Col>
      </Row>
      <Stack className='desc-panel-text'>
          
            <div className='about-title'>Anim nostrud</div>
            <div className='about-description'>Anim ad nostrud tempor mollit eu laboris duis laborum qui minim aute eu. Sint sit deserunt adipisicing laboris laborum culpa do ipsum adipisicing commodo et et. </div>
            <Row className="about-row">
              <Col xl={4}>
                <div className='about-icon'>
                  <FontAwesomeIcon  className="mr-2"/>
                </div>
                <div className='about-mini-title'>Anim nostrud</div>
                <div className='about-mini-desc'>Anim ad nostrud tempor mollit eu laboris</div>
              </Col>
              <Col xl={4}>
                <div className='about-icon'>
                  <FontAwesomeIcon  className="mr-2"/>
                </div>
                <div className='about-mini-title'>Anim nostrud</div>
                <div className='about-mini-desc'>Anim ad nostrud tempor mollit eu laboris</div>
              </Col>
              <Col xl={4}>
                <div className='about-icon'>
                  <FontAwesomeIcon  className="mr-2"/>
                </div>
                <div className='about-mini-title'>Anim nostrud</div>
                <div className='about-mini-desc'>Anim ad nostrud tempor mollit eu laboris</div>
              </Col>
            </Row>
            <Row className="about-row">
              <Col xl={4}>
                <div className='about-icon'>
                  <FontAwesomeIcon  className="mr-2"/>
                </div>
                <div className='about-mini-title'>Anim nostrud</div>
                <div className='about-mini-desc'>Anim ad nostrud tempor mollit eu laboris</div>
              </Col>
              <Col xl={4}>
                <div className='about-icon'>
                  <FontAwesomeIcon  className="mr-2"/>
                </div>
                <div className='about-mini-title'>Anim nostrud</div>
                <div className='about-mini-desc'>Anim ad nostrud tempor mollit eu laboris</div>
              </Col>
              <Col xl={4}>
                <div className='about-icon'>
                  <FontAwesomeIcon  className="mr-2"/>
                </div>
                <div className='about-mini-title'>Anim nostrud</div>
                <div className='about-mini-desc'>Anim ad nostrud tempor mollit eu laboris</div>
              </Col>
            </Row>
      </Stack>
      <Row className='stats-panel'>
          <Col>
            <Stack>
              <Col className='stats-title'>400+</Col>
              <Col className='stats-desc'>Communities</Col>
            </Stack>
          </Col>
          <Col>
            <Stack>
              <Col className='stats-title'>200K</Col>
              <Col className='stats-desc'>Messages Sent</Col>
            </Stack>
          </Col>
          <Col>
            <Stack>
              <Col className='stats-title'>$15M</Col>
              <Col className='stats-desc'>Profits Earned</Col>
            </Stack>
          </Col>
        </Row>
        <section className="contact" id="contact">
            <div className="contact__form-wrapper">
                <form className="contact__form">
                    <h3 className="contact__title">Get in Touch</h3>
                    <fieldset className="contact__form__fieldset">
                        <input type="email" className="contact__form__input" id="email" name="email" required
                            placeholder="Email" />
                        <textarea className="contact__form__input-txt" placeholder="Enter Your Message" required
                            name="message"></textarea>
                    </fieldset>
                    <fieldset className="contact__form__fieldset">
                        <button type="submit" className="contact__form__button">Send Request</button>
                    </fieldset>
                </form>
            </div>
            <div className="contact__info">
                {/* <p className="contact__info-txt">contact</p> */}
                <h2 className="contact__info-title">Don’t Hesitate To Choose Us</h2>
                <p className="contact__info-subtitle">Enim laborum anim magna do cillum. Eiusmod qui et et pariatur veniam. Aute amet qui exercitation voluptate occaecat est exercitation nisi ea do eiusmod enim Lorem magna.</p>
                <ul className="contact__info__address">
                    <li className=" contact__info__address-item">
                        <a href="#" className="contact__info__address-icon">contact@mocean.info</a>
                    </li>
                </ul>
            </div>
        </section>
        
      <Stack className='review-panel-text'>
          
          <Row className="review-row">
            <Col xl={4}>
              <div className='big-review-card'>

              </div>
            </Col>
            <Col xl={4}>
              <div className='review-title'>Reviews</div>
              <div className='medium-review-card'>

              </div>
            </Col>
            <Col xl={4}>
              <div className='small-review-card'>
                {/* <div className='review-card-input'>
                  x
                </div> */}
              </div>
              <div className='small-review-card'>

              </div>
            </Col>
          </Row>
      </Stack>
      <Row className='social-panel'>
        <div className="social-title">Follow Us</div>
          <Col>
            <Stack className="social-card">
              <Col className='social-icon'>
                <FontAwesomeIcon icon={faTwitter} className="mr-2"/>
              </Col>
            </Stack>
          </Col>
          <Col>
            <Stack className="social-card">
              <Col className='social-icon'>
                <FontAwesomeIcon icon={faTwitter} className="mr-2"/>
              </Col>
            </Stack>
          </Col>
          <Col>
          <Stack className="social-card">
              <Col className='social-icon'>
                <FontAwesomeIcon icon={faTwitter} className="mr-2"/>
              </Col>
            </Stack>
          </Col>
        </Row>
        <div className="footer">
          <div className="footer__elements">
            <div className="footer__company">
                <a href="#home" className="footer__logo"></a>
                <p className="footer__company-txt">Automate your marketing, convert more leads, and recruit new partners
                    using one simple CRM solution.</p>
            </div>
            <div className="footer__item">
                <h4 className="footer__item-title">
                    Quick link
                </h4>
                <ul className="footer__list">
                    <li className="footer__list-item"><a href="#home" className="footer__list-item">Home</a>
                    </li>
                    <li className="footer__list-item"><a href="#services" className="footer__list-item">Services</a>
                    </li>
                    <li className="footer__list-item"> <a href="#about" className="footer__list-item">About</a>
                    </li>
                    <li className="footer__list-item"><a href="#portfolio" className="footer__list-item">Case Studies</a>
                    </li>
                    <li className="footer__list-item"><a href="#contact" className="footer__list-item">Get in Touch</a></li>
                </ul>
            </div>
            <div className="footer__item">
                <h4 className="footer__item-title"> Resources </h4>
                <ul className="footer__list">
                    <li className="footer__list-item"> <a href="#" className="footer__list-item">Privacy</a>
                    </li>
                    <li className="footer__list-item"> <a href="#" className="footer__list-item">Terms & Condition</a></li>
                    <li className="footer__list-item"><a href="#" className="footer__list-item">Security</a></li>
                </ul>
            </div>
            <div className="footer__item">
                <div className="footer__social">
                </div>
            </div>
          </div>
          <p className="footer__rights">© All the rights are reserved </p>
      </div>

    </div>
  );
};

if(document.getElementById('landing')){
  ReactDOM.render(<Landing/>,document.getElementById('landing'))
}

