package com.company;

import java.io.Serializable;
import java.util.Date;
import java.util.*;
import com.company.Devices.*;

public class Order implements Serializable {
    public String Status;
    public Date CreationTime;
    public User OurUser;
    public List<Device> PurchasingItemsList = new ArrayList<>();

    public Order(ShoppingCart m_PurchasingItems, Credentials m_Customers, int Customer) {
        Status = "Ожидание";
        CreationTime = new Date();
        PurchasingItemsList = m_PurchasingItems.ShoppingCartList;
        User[] UsersArray = {};
        UsersArray = m_Customers.Users.toArray(new User[m_Customers.Users.size()]);
        OurUser = UsersArray[Customer];
    }

    public Order() {
        Status = "Empty Order";
    }

}
