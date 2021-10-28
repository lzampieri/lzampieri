import { Collapse } from "@mui/material";
import { PureComponent } from "react";
import ThesisListItem from "./thesisListItem";

class ThesisListCollapser extends PureComponent {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <Collapse in={this.props.open} >
                <ThesisListItem {...this.props} />
            </Collapse>
        )
    }
}

export default ThesisListCollapser;