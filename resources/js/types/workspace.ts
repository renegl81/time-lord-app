// resources/js/types/Workspace.ts
export interface Workspace {
    id: number;
    name: string;
    hourly_rate: number | null;
    currency: string | null;
    settings: {
        [key: string]: any;
    };
}
