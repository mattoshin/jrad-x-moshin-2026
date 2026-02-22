const Footer = () => {
  return (
    <footer className="galactic-footer">
      <div className="galactic-footer-inner">
        <div className="galactic-footer-brand">
          <span className="galactic-footer-logo">Galactic</span>
          <p className="galactic-footer-tagline">Financial Alpha for the Investors of Tomorrow</p>
        </div>
        <div className="galactic-footer-links">
          <div className="galactic-footer-col">
            <h4>Platform</h4>
            <a href="/">Home</a>
            <a href="/login">Dashboard</a>
            <a href="https://discord.gg/F7syGdJMZq" target="_blank" rel="noreferrer">Discord</a>
          </div>
          <div className="galactic-footer-col">
            <h4>Legal</h4>
            <a href="/privacy-policy">Privacy Policy</a>
            <a href="/terms-and-conditions">Terms & Conditions</a>
          </div>
        </div>
      </div>
      <div className="galactic-footer-bottom">
        <p>© {new Date().getFullYear()} Galactic. All rights reserved.</p>
      </div>
    </footer>
  );
};

export default Footer;
