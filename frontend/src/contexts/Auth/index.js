import React, { useState, useEffect, createContext, useContext } from "react";
import { useLocalstorageState  } from "rooks";

const initialState = {
  token: "",
  isLogined: false,
  userEmail: "",
  userName: "",
  login: () => {},
  logout: () => {},
};

export const AuthContext = createContext(initialState);

export const useAuthContext = () => useContext(AuthContext);

export const AuthProvider = ({ children }) => {
  const [value, set] = useLocalstorageState("auth-state", initialState);
  const [state, setState] = useState(value);

  useEffect(() => {
    set(state);
    return () => {};
  }, [state, set]);

  const login = (token, userEmail, userName) => {
    const tempState = {
      token,
      userEmail,
      isLogined: true,
      userName
    };

    setState({ ...state, ...tempState });
    localStorage.setItem("token", token);
  }

  const logout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("username");
    localStorage.removeItem("email");
    localStorage.removeItem("avatar");
    localStorage.removeItem("business_token");
    setState(initialState);
  }

  return(
    <AuthContext.Provider
      value={{
        ...state,
        login,
        logout
      }}
    >
      {children}
    </AuthContext.Provider>
  )
}