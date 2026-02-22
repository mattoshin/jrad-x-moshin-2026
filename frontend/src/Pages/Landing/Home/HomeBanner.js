import { useNavigate } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faDiscord } from "@fortawesome/free-brands-svg-icons";
import { faArrowRight } from "@fortawesome/free-solid-svg-icons";

const HomeBanner = () => {
  const navigate = useNavigate();
  return (
    <div className="galactic-hero">
      <div className="galactic-hero-badge">Data Intelligence Platform</div>
      <h1 className="galactic-hero-title">
        Financial Alpha for the
        <br />
        <span className="galactic-hero-accent">Investors of Tomorrow</span>
      </h1>
      <p className="galactic-hero-subtitle">
        Real-time market data, stock insights, crypto signals, and multi-vertical
        intelligence — all in one place.
      </p>
      <div className="galactic-hero-actions">
        <button
          className="galactic-hero-btn-primary"
          onClick={() => navigate("/login")}
        >
          Get Started <FontAwesomeIcon icon={faArrowRight} style={{ marginLeft: 8 }} />
        </button>
        <a
          className="galactic-hero-btn-secondary"
          href="https://discord.gg/F7syGdJMZq"
          target="_blank"
          rel="noreferrer"
        >
          <FontAwesomeIcon icon={faDiscord} style={{ marginRight: 8 }} />
          Join Discord
        </a>
      </div>
    </div>
  );
};

export default HomeBanner;
