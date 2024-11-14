import resolveConfig from "tailwindcss/resolveConfig";
import tailwindConfigFile from "@tailwindConfig";

export const tailwindConfig = () => {
    return resolveConfig(tailwindConfigFile);
};
