import { Outlet } from "react-router-dom";
import SideBar from "./SideBar";
import { useEffect, useState } from "react";
import TopBar from "./Topbar/TopBar";

const Layout = (props, { children }) => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);

  useEffect(() => {
    //Makes sure sidebar is closed when app first opens on smaller screens
    if (window.innerWidth <= 1300) {
      setIsSidebarOpen(false);
    }

    //Ensures sidebar stays open on bigger screens
    window.addEventListener("resize", () => {
      if (window.innerWidth > 1300) {
        setIsSidebarOpen(true);
      }
    });

    return () =>
      window.removeEventListener("resize", () => {
        if (window.innerWidth > 1300) {
          setIsSidebarOpen(true);
        }
      });
  }, []);

  return (
    <>
      <div style={{ width: isSidebarOpen ? "250px" : "0px" }}>
        <SideBar
          isSidebarOpen={isSidebarOpen}
          setIsSidebarOpen={setIsSidebarOpen}
        />
      </div>
      <div
        style={{
          width: isSidebarOpen ? `calc(100vw - 250px)` : `calc(100vw)`,
          transition: "width 0.5s",
          height: "100vh",
          float: "right",
          overflow: "auto",
          backgroundColor: "#171a23",
          paddingTop: "50px",
        }}
      >
        <TopBar 
          isSidebarOpen={isSidebarOpen}
          setIsSidebarOpen={setIsSidebarOpen}>
          <Outlet />
        </TopBar>
      </div>
    </>
  );
};

export default Layout;
