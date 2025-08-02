import {Project} from "@/types/project";

export interface Client {
    id: number;
    name: string;
    email: string;
    phone?: string;
    contact_info: string;
    address: string;
    projects?: Project[];
}
