package com.company;

import java.util.*;

public class User {
    String Name;
    String Sname;
    String FatherName;
    String Mail;
    UUID id;
    User(String m_Name, String m_Sname, String m_FatherName, String m_Mail) {
        Name = m_Name;
        Sname = m_Sname;
        FatherName = m_FatherName;
        Mail = m_Mail;
        id = UUID.randomUUID();
    }

    public void ReadUser() {
        System.out.println("Id: "+id);
        System.out.println("Имя: "+Name);
        System.out.println("Фамилия: "+Sname);
        System.out.println("Отчество: "+FatherName);
        System.out.println("E-mail: "+Mail);
    }
    public UUID GetId() {
        return id;
    }
    public String GetName() {
        return Name;
    }
    public String GetSname() {
        return Sname;
    }
    public String GetFatherName() {
        return FatherName;
    }
    public String GetMail() {
        return Mail;
    }
}