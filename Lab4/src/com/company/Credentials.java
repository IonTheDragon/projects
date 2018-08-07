package com.company;

import java.util.*;

public class Credentials {

    HashSet<User> Users = new HashSet<>();

    public void AddUser(String m_Name, String m_Sname, String m_FatherName, String m_Mail) {
        Users.add(new User(m_Name, m_Sname, m_FatherName, m_Mail));
    }
    public void GetUser(int i) {
        User[] UsersArray = {};
        UsersArray = Users.toArray(new User[Users.size()]);
        UsersArray[i].ReadUser();
    }
}

