import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faDiscord, faTwitter } from "@fortawesome/free-brands-svg-icons";

const HomeConnect = () => {
  return (
    <section className="galactic-connect">
      <h2 className="galactic-section-title">Join the community</h2>
      <p className="galactic-section-subtitle">
        Connect with traders and analysts using Galactic every day.
      </p>
      <div className="galactic-connect-cards">
        <a
          className="galactic-connect-card"
          href="https://discord.gg/F7syGdJMZq"
          target="_blank"
          rel="noreferrer"
        >
          <FontAwesomeIcon icon={faDiscord} className="galactic-connect-icon galactic-connect-discord" />
          <span>Discord</span>
        </a>
        <a
          className="galactic-connect-card"
          href="https://twitter.com/galacticdata"
          target="_blank"
          rel="noreferrer"
        >
          <FontAwesomeIcon icon={faTwitter} className="galactic-connect-icon" />
          <span>Twitter</span>
        </a>
      </div>
    </section>
  );
};

export default HomeConnect;
