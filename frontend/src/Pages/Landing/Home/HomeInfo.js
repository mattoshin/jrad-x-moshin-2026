import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faChartLine,
  faBitcoinSign,
  faNewspaper,
  faHouse,
  faTrophy,
  faLayerGroup,
} from "@fortawesome/free-solid-svg-icons";

const features = [
  {
    icon: faChartLine,
    title: "Stocks",
    desc: "Real-time quotes, sentiment analysis, earnings reports, and market movers.",
  },
  {
    icon: faBitcoinSign,
    title: "Crypto",
    desc: "Digital asset signals, on-chain data, and DeFi market intelligence.",
  },
  {
    icon: faTrophy,
    title: "Sports",
    desc: "Live scores, stats, and data feeds across major leagues.",
  },
  {
    icon: faHouse,
    title: "Real Estate",
    desc: "Property market trends, listings data, and investment signals.",
  },
  {
    icon: faNewspaper,
    title: "News",
    desc: "Curated breaking news and macro trends across all verticals.",
  },
  {
    icon: faLayerGroup,
    title: "Multi-Vertical",
    desc: "Cards, collectibles, and more — all through a single unified platform.",
  },
];

const HomeInfo = () => {
  return (
    <section className="galactic-features" id="about-us">
      <div className="galactic-features-header">
        <h2 className="galactic-section-title">Everything you need to stay ahead</h2>
        <p className="galactic-section-subtitle">
          Seven data verticals. One platform. Zero noise.
        </p>
      </div>
      <div className="galactic-features-grid">
        {features.map((f) => (
          <div className="galactic-feature-card" key={f.title}>
            <div className="galactic-feature-icon">
              <FontAwesomeIcon icon={f.icon} />
            </div>
            <div className="galactic-feature-title">{f.title}</div>
            <div className="galactic-feature-desc">{f.desc}</div>
          </div>
        ))}
      </div>
    </section>
  );
};

export default HomeInfo;
