import { invoices as invoicesApi } from "../../../../api";
import { InvoiceCard } from "./InvoiceCard";
import { useEffect, useState } from "react";

const Invoices = () => {
  const [ invoices, setInvoices ] = useState([]);
  useEffect(()=>{
    const getData = async () => {
      const invoicesResponse = await invoicesApi();
      setInvoices(invoicesResponse.data.invoices);
    };
    getData();
  }, []);

  return (
    <div className="main-cards-wrapper col-md-12 col-lg-8 p-3">
      <div className="main-card">
        <div className="main-wrapper-up">
          <h5 className="text-white align-items-center d-flex h-100">
            Invoices
          </h5>
        </div>
        <div
          className="ps-3 pe-3 "
          style={{
            marginTop: "16px",
            marginBottom:"5px",
            backgroundColor: "#1e222b",
            position: "sticky",
            top: 0,
            zIndex: "1000 !important",
          }}
        >
          <div className="row ">
            <div
              style={{ fontWeight: "lighter" }}
              className="custom-table-cols-active product-col col-3 col-lg-3"
            >
              <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                Product Name
              </h6>
            </div>
            <div
              style={{ fontWeight: "lighter" }}
              className="custom-table-cols-active product-col col-2 col-lg-2  d-none d-md-block"
            >
              <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                Billing Name
              </h6>
            </div>
            <div className="custom-table-cols-active product-col col-3">
              <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                Purchase Date
              </h6>
            </div>

            <div className="custom-table-cols-active progress-col col-2">
              <h6 className="text-white" style={{ fontWeight: "lighter" }}>Amount</h6>
            </div>

            <div className="custom-table-cols-active status-col col-2">
              <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                Status
              </h6>
            </div>
          </div>
        </div>
        <div className="mt-1 cards-holder-active" style={{}}>
          {invoices.map((invoice)=>{
            return (
              <InvoiceCard 
                key={invoice.id} 
                id={invoice.id} 
                product_name={invoice.product.name} 
                billing_name={invoice.billing_name} 
                payment_amount={invoice.payment_amount}
                date={invoice.creation_date}
                status={invoice.paid}
              />
            )
          })}
        </div>
      </div>
    </div>
  );
};

export default Invoices;
