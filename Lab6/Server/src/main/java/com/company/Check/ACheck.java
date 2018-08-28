package com.company.Check;
import com.company.*;

abstract public class ACheck implements Runnable {
    int Time;
    int count;
    Orders orders;

    ACheck(int m_time, int m_count, Orders m_orders) {
        this.Time = m_time;
        this.count = m_count;
        this.orders = m_orders;
    }

    @Override
    public void run()
    {

    }

}
