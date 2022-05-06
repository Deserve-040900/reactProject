import React, { useState } from 'react';
import { Link } from 'react-router-dom';

import Header from './Header';
import Navbar from './NavLink';
import SideDrawer from './SlideDrawer';
import './MainNavigation.css';
import Backdrop from '../UIElement/Backdrop';

const MainNavigation = (props) => {
    const [drawerIsOpen, setDrawerIsOpen] = useState(false);
  
    const openDrawerHandler = () => {
      setDrawerIsOpen(true);
    };
  
    const closeDrawerHandler = () => {
      setDrawerIsOpen(false);
    };
  
    return (
      <React.Fragment>
        {drawerIsOpen && <Backdrop onClick={closeDrawerHandler} />}
        <SideDrawer show={drawerIsOpen} onClick={closeDrawerHandler}>
          <nav className="main-navigation__drawer-nav">
            <Navbar />
          </nav>
        </SideDrawer>
  
        <Header>
          <button
            className="main-navigation__menu-btn"
            onClick={openDrawerHandler}
          >
            <span />
            <span />
            <span />
          </button>
          <h1 className="main-navigation__title">
            <Link to={'/'}>ZOOTUBE</Link>
          </h1>
          <nav className="main-navigation__header-nav">
            <Navbar />
          </nav>
        </Header>
      </React.Fragment>
    );
  };
  
export default MainNavigation;