import React from "react";
import { useForm } from "@inertiajs/react";
import { Head, Link } from "@inertiajs/react";

export default function Dashboard({ users }) {
    const { data, setData, post, processing, errors } = useForm({
        user_id: "",
        amount: "",
    });
    console.log(users);
    const handleCredit = (e) => {
        e.preventDefault();
        post("/admin/credit", {
            onSuccess: () => setData({ user_id: "", amount: "" }),
        });
    };

    const handleDebit = (e) => {
        e.preventDefault();
        post("/admin/debit", {
            onSuccess: () => setData({ user_id: "", amount: "" }),
        });
    };

    // Ensure users is initialized properly
    // const [users, setUsers] = useState([]);

    return (
        <div>
            <Head title="Admin Dashboard" />
            <h2>Admin Dashboard</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    {users.length > 0 ? (
                        users.map((user) => (
                            <tr key={user.id}>
                                <td>{user.id}</td>
                                <td>
                                    $
                                    {user.wallet
                                        ? user.wallet.balance.toFixed(2)
                                        : "0.00"}
                                </td>
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td colSpan="2">No users available.</td>
                        </tr>
                    )}
                </tbody>
            </table>
            <h3>Credit Wallet</h3>
            <form onSubmit={handleCredit}>
                <div>
                    <label>User ID</label>
                    <input
                        type="number"
                        value={data.user_id}
                        onChange={(e) => setData("user_id", e.target.value)}
                    />
                    {errors.user_id && <div>{errors.user_id}</div>}
                </div>
                <div>
                    <label>Amount</label>
                    <input
                        type="number"
                        value={data.amount}
                        onChange={(e) => setData("amount", e.target.value)}
                    />
                    {errors.amount && <div>{errors.amount}</div>}
                </div>
                <button type="submit" disabled={processing}>
                    Credit
                </button>
            </form>
            <h3>Debit Wallet</h3>
            <form onSubmit={handleDebit}>
                <div>
                    <label>User ID</label>
                    <input
                        type="number"
                        value={data.user_id}
                        onChange={(e) => setData("user_id", e.target.value)}
                    />
                    {errors.user_id && <div>{errors.user_id}</div>}
                </div>
                <div>
                    <label>Amount</label>
                    <input
                        type="number"
                        value={data.amount}
                        onChange={(e) => setData("amount", e.target.value)}
                    />
                    {errors.amount && <div>{errors.amount}</div>}
                </div>
                <button type="submit" disabled={processing}>
                    Debit
                </button>
            </form>
            <Link href={route("admin.reports")}>View Reports</Link>
        </div>
    );
}
