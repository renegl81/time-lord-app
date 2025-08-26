// resources/js/types/Project.ts

import { Workspace } from '@/types/workspace';
import {User} from "@/types/user";
import {Task} from "@/types/task";
import {TimeEntry} from "@/types/timeEntry";
import {Client} from "@/types/client";
export interface Project {
    id?: number;
    name: string;
    description?: string;
    status: string;
    client_id?: number;
    client?: Client;
    is_billable: boolean;
    is_public: boolean;
    color: string;
    hourly_rate?: number;
    budget?: number;
    estimate?: number;
    created_at: string;
    users: User[];
    tasks: Task[];
    time_entries: TimeEntry[];
    workspace: Workspace;
    workspace_id: number;
}
