export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
};

export type SafeUser = Omit<
    User,
    'email' | 'avatar' | 'email_verified_at' | 'created_at' | 'updated_at'
>;

export type Roles = {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
};
export type UserWithRoles = SafeUser & { roles: Array<any> };

/* @chisel-passkeys */
export type Passkey = {
    id: number;
    name: string;
    authenticator: string | null;
    created_at_diff: string;
    last_used_at_diff: string | null;
};
/* @end-chisel-passkeys */
