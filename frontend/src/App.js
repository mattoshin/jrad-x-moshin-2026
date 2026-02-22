import "./App.css";
import NavBar from "./components/Navbar/NavBar";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { Contact } from "./Pages/Info/Contact";
import { Home } from "./Pages/Landing/Home";
import Layout from "./components/Layout";
import Layout2 from "./components/Layout2";
import TopBar2 from "./components/Layout2/Topbar/TopBar";
import DashboardHome from "./Pages/Dashboard/Home";
import SwitchBusiness from "./components/Dashboard/Business/SwitchBusiness";
import Products from "./Pages/Dashboard/Products";
import ActiveProducts from "./Pages/Dashboard/ActiveProducts";
import ManageMonitors from "./Pages/Dashboard/ManageMonitors";
import Invoices from "./Pages/Dashboard/Invoices";
import Account from "./Pages/Dashboard/Account";
import InvoiceDetail from "./Pages/Dashboard/Invoice";
import SuccessPage from "./Pages/Dashboard/Success";
import CancelPage from "./Pages/Dashboard/Cancel";
import Privacy from "./Pages/Info/Privacy";
import Terms from "./Pages/Info/Terms";
import { ToastContainer } from "react-toastify";
import RequireAuth from "./components/Authentication";
import Guild from "./Pages/Guild";
import Login from "./components/Login";
import Logout from "./components/Logout";
import Handle from "./Pages/Handle";
import BusinessAuthentication from "./components/BusinessAuthentication";

function App() {
  return (
    <Router>
      <ToastContainer
        theme="dark"
        position="bottom-right"
        autoClose={false}
        hideProgressBar={false}
        draggable={false}
        newestOnTop={false}
        rtl={false}
        closeButton={false}
        closeOnClick={false}
        style={{ width: "900px" }}
      />
      {/* {location === "/" && <NavBar />} */}
      {/* <NavBar /> */}
      <Routes>
        <Route element={<NavBar />}>
          <Route path="/" element={<Home />} />
          <Route path="/*" element={<Home />} />
          <Route path="/handle" element={<Handle />} />
          <Route path="/auth/discord/callback" element={<Handle />} />
          <Route path="/guild-oauth" element={<Guild />} />
          <Route path="/logout" element={<Logout />} />
        </Route>
        <Route path="/login" element={<Login />} />
        <Route element={<RequireAuth />}>
          <Route element={<Layout />}>
              <Route path="/contact" element={<Contact />} />
              {/* <Route
                path="/dashboard"
                element={
                  <h1
                    className="p-5"
                    style={{
                      color: "#fff",
                    }}
                  >
                    <DashboardHome />
                  </h1>
                }
              /> */}
          </Route>

          <Route element={<BusinessAuthentication />}>
              <Route element={<Layout />}>
                  <Route path="/home" element={<DashboardHome />} />
                  <Route path="/manage/:id" element={<ManageMonitors />} />
                  <Route path="/products" element={<Products />} />
                  <Route path="/active-products" element={<ActiveProducts />} />
                  <Route path="/invoices" element={<Invoices />} />
                  <Route path="/account" element={<Account />} />
              </Route>
              <Route path="/invoice/:id" element={<InvoiceDetail />} />
              <Route path="/success" element={<SuccessPage />} />
              <Route path="/success/:id" element={<SuccessPage />} />
              <Route path="/cancel" element={<CancelPage />} />
              <Route path="/cancel/:id" element={<CancelPage />} />
          </Route>
          <Route element={<Layout2 />}>
            <Route element={<TopBar2 />}>
              <Route path="/switch-business" element={<SwitchBusiness />} />
              <Route path="/dashboard" element={<SwitchBusiness />} />
            </Route>
          </Route>
        </Route>

        <Route path="/privacy-policy" element={<Privacy />} />
        <Route path="/terms-and-conditions" element={<Terms />} />
        {/* <Route path="/about" element={About} />
          <Route path="/blog" element={Blog} /> */}
      </Routes>
    </Router>
  );
}

export default App;
