import { usePage } from "@inertiajs/inertia-react"
import { Stack } from "@mui/material";
import React from "react"
import SectionMenuItem from "./SectionsMenuItem";


export default function SectionsMenu() {
    const { auth, sections } = usePage().props;
    return (
        <Stack spacing={2}>
            { auth && <SectionMenuItem title={ auth.name } disabled key="name"/> }
            { !auth && <SectionMenuItem title="Login" url="/u/login" key="login"/>  }
            { !auth && <SectionMenuItem title="Registrati" url="/u/register" key="register"/>  }
            { auth && <SectionMenuItem title="Home" url="/" key="homepage"/>  }
            { sections.map( s => <SectionMenuItem title={ s.title } url={ "/s/" + s.shortname } key={ s.shortname } /> ) }
            { auth && auth.permissions.includes('edit users') && <SectionMenuItem title="Gestione utenti" url="/u/edit" key="edit_users"/> }
            { auth && <SectionMenuItem title="Logout" url="/u/logout" key="logout"/>  }
        </Stack>
    )
}