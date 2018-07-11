import java.util.UUID;
public class List {
	public static void main (String args[]) {
		ShoppingCart test = new ShoppingCart();
		UUID id1 = UUID.randomUUID();
		UUID id2 = UUID.randomUUID();
		UUID id3 = UUID.randomUUID();
		test.add(id1,"tst1");
		test.add(id2,"tst2");
		test.add(id3,"tst3");
		test.show();
	}
}
