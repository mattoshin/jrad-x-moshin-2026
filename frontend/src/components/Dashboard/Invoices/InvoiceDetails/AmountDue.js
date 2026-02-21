export const AmountDue = (props) => {
  return (
    <div
      style={{ height: "fit-content" }}
      className="main-cards-wrapper col-12 p-3"
    >
      <div className="main-card py-3">
        <div className="main-wrapper-up">
          <h5 className="text-white align-items-center d-flex h-100">
            Amount Due (USD)
          </h5>
        </div>
        <div
          className="col-12 d-flex flex-direction-row justify-content-between  m-auto my-4 text-white"
          style={{ borderBottom: "1px solid #444", width: "90%" }}
        >
          <h6 style={{ fontSize: "25px", fontWeight: "600" }}>{`$${props.invoice.payment_amount}`}.00</h6>
          <p
            style={{
              fontSize: "15px",
              borderRadius: "4px",
              backgroundColor: "#171A23",
              padding: "6px 14px",
              color: props.invoice.paid? "#50E34D" : "#FC5B5B",
            }}
          >
            {props.invoice.paid? "Paid": "Unpaid"}
          </p>
        </div>
        <div className="col-12 text-white px-4">
          <input
            type="checkbox"
            className="form-check-input"
            id="include_pdf"
            style={{ backgroundColor: "#2F3540" }}
          />
          <label className="form-check-label mx-3" htmlFor="include_pdf">
            Attach PDF in mail
          </label>
        </div>
      </div>
    </div>
  );
};
