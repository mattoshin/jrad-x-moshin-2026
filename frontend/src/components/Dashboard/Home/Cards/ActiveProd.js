import ActiveSubCard from "./ActiveSubCard";
import { 
  activeProducts as activeProductsApi,
} from "../../../../api";
import { useEffect, useState } from "react";

const ActiveProd = () => {
  const [prodcuts, setProducts] = useState([]);

  useEffect(()=>{
    const getData = async () => {
      const productsResponse = await activeProductsApi();
      setProducts(productsResponse.data);
    };
    getData();
  }, []);

  return (
    <div className="main-cards-wrapper col-md-12 col-lg-8 p-3">
      <div className="main-card">
        <div className="main-wrapper-up">
          <h5 className="text-white align-items-center d-flex h-100">
            Active Products
          </h5>
        </div>
        <div>
          <div
            className="ps-3 pe-3"
            style={{
              marginTop: "16px",
              marginBottom:"5px",
              backgroundColor: "#1e222b",
              position: "sticky",
              top: 0,
              zIndex: "1000 !important",
            }}
          >
            <div className="row">
              <div className="custom-table-cols-active product-col col-3 col-md-4">
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Product Details
                </h6>
              </div>
              <div className="custom-table-cols-active product-col col-2 col-sm-2 col-md-2 col-lg-2">
                <h6 className="text-white text-center" style={{ fontWeight: "lighter" }}>
                  Price
                </h6>
              </div>

              <div className="custom-table-cols-active progress-col col-4 col-sm-4 col-md-3 col-lg-3">
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Time Remaining
                </h6>
              </div>

              <div className="custom-table-cols-active status-col col-3 col-md-2">
                <h6 className="text-white" style={{ fontWeight: "lighter" }}>
                  Status
                </h6>
              </div>
            </div>
          </div>
        </div>
        <div className="mt-1 cards-holder-active text-center">
          {
            prodcuts.map((product)=>{
              return (
                <ActiveSubCard 
                  key={product.id} 
                  id={product.id} 
                  category={product.category} 
                  name={product.name}
                  description={product.description}
                  price={product.price}
                  days_left={product.days_left}
                  trial={product.trial}
                />
              )
            })
          }
          <div 
            style={{
              paddingTop: "40px"
            }}
          >
            <a
              className="add-product"
              href="/products"
            >Add A Product</a>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ActiveProd;
