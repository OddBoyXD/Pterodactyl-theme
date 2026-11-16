import http from "@/api/http";

export interface Announcement {
    id: number;
    title: string;
    content: string;
    category: "info" | "warning" | "danger" | "update";
    action_text?: string;
    action_url?: string;
    is_active: boolean;
    created_at: string;
    updated_at: string;
}

export default (): Promise<Announcement[]> => {
    return new Promise((resolve, reject) => {
        http.get("/api/client/announcements")
            .then(({ data }) => resolve(data || []))
            .catch(reject);
    });
};
