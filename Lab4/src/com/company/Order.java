package com.company;

import java.util.Date;
import java.util.*;
import com.company.Devices.*;

public class Order {
    public String Status;
    public Date CreationTime;
    public ShoppingCart PurchasingItems = new ShoppingCart();
    public User OurUser;
    public ArrayList<Device> PurchasingItemsList = new ArrayList<>();

    Order(ShoppingCart m_PurchasingItems, Credentials m_Customers, int Customer) {
        Status = "Ожидание";
        CreationTime = new Date();
        PurchasingItemsList = m_PurchasingItems.ShoppingCartList;
        User[] UsersArray = {};
        UsersArray = m_Customers.Users.toArray(new User[m_Customers.Users.size()]);
        OurUser = UsersArray[Customer];
    }

}
