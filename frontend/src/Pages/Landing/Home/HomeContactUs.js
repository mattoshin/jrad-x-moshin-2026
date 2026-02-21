const ContactUs = () => {
  return (
    <section style={{ marginTop: "150px" }} className="contact" id="contact">
      <div className="contact__form-wrapper">
        <form className="contact__form">
          <h3 className="contact__title">Get in Touch</h3>
          <fieldset className="contact__form__fieldset">
            <input
              type="email"
              className="contact__form__input"
              id="email"
              name="email"
              required
              placeholder="Email"
            />
            <textarea
              className="contact__form__input-txt"
              placeholder="Enter Your Message"
              required
              name="message"
            ></textarea>
          </fieldset>
          <fieldset className="contact__form__fieldset">
            <button type="submit" className="contact__form__button">
              Send Request
            </button>
          </fieldset>
        </form>
      </div>
      <div className="contact__info">
        {/* <p className="contact__info-txt">contact</p> */}
        <h2 className="contact__info-title">
          Excellence in Content <i>and</i> Customer Service!
        </h2>
        <p className="contact__info-subtitle">
          Think Mocean is right for you? Schedule a personalized 1-on-1 call
          with a member of our team to discuss how we can best cater our
          services to your community.
        </p>
        <ul className="contact__info__address">
          <li className=" contact__info__address-item">
            <a href="#" className="contact__info__address-icon">
              support@mocean.info
            </a>
          </li>
        </ul>
      </div>
    </section>
  );
};

export default ContactUs;
