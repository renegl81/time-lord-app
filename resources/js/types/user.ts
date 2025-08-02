// resources/js/types/User.ts
export interface User {
    id: number;
    name: string;
    email: string;
    role?: string;
    pivot?: {
        role: string;
    };
}
